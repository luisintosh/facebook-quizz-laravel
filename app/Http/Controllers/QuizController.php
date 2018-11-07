<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuiz;
use App\Quiz;
use App\QuizImage;
use App\User;
use App\UserQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class QuizController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['random', 'show', 'doQuiz', 'quizResult']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::all();
        return view('quizzes.index', ['quizzes' => $quizzes]);
    }

    /**
     * Display a random list of quizzes without layout to infinite scroll function
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function random()
    {
        return view('quizzes.random-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $quiz = new Quiz();
        return view('quizzes.form', ['quiz' => $quiz]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuiz $request)
    {
        $success = false;

        try {
            DB::beginTransaction();

            $quiz = new Quiz($request->all());

            if ($quiz->save() && $request->file('coverImage')->isValid()) {

                $coverPath = $quiz->getStorageDirName() . DIRECTORY_SEPARATOR . Quiz::COVER_IMAGE_NAME;
                $thumbPath = $quiz->getStorageDirName() . DIRECTORY_SEPARATOR . Quiz::THUMB_IMAGE_NAME;

                // Cover image
                $coverImage = Image::make($request->file('coverImage'))
                    ->encode('jpg', 85);

                // Thumb image
                $thumbImage = Image::make($request->file('coverImage'))
                    ->fit(300, 157)
                    ->encode('jpg', 85);

                // Save files
                Storage::disk('public')->put($coverPath, (string)$coverImage);
                Storage::disk('public')->put($thumbPath, (string)$thumbImage);

                // Check results
                if (Storage::disk('public')->exists($coverPath) && Storage::disk('public')->exists($thumbPath)) {
                    $quiz->coverImage = $coverPath;
                    $quiz->thumbImage = $thumbPath;

                    if ($quiz->save()) {
                        $success = true;
                        DB::commit();
                    }
                }
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', $exception->getMessage());
        }

        if ($request->has('save') && $success) {
            return redirect()->route('quizzes.edit', [$quiz->id])
                ->with('success', __('¡Quiz guardado con éxito!'));
        } elseif ($request->has('saveNClose') && $success) {
            return redirect()->route('quizzes.index')
                ->with('success', __('¡Quiz guardado con éxito!'));
        } else {
            return back()->withInput()
                ->with('error', __('No se ha podido guardar el Quiz'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $quiz = Quiz::where([['enabled', '=', true], ['slug', '=', $slug]])->firstOrFail();
        return view('quizzes.show', ['quiz' => $quiz]);
    }

    public function doQuiz($slug)
    {
        if (! Auth::check()) {
            return redirect()->route('social.auth', ['provider' => 'facebook']);
        }

        $quiz = Quiz::where([['enabled', '=', true], ['slug', '=', $slug]])->firstOrFail();
        $user = User::findOrFail(Auth::id());
        $success = false;
        $errorMsg = __('Oops! Tuvimos un problema al calcular tu resultado');

        // Place user avatar on cover image
        try{
            // Random image url
            $randomImage = $quiz->images()->inRandomOrder()->firstOrFail();
            if (! Storage::disk('public')->exists($randomImage->imageUrl)) {
                throw new Exception(__('Error: No existe la siguiente imagen: ' . $randomImage->imageUrl));
            }

            $randomImage = Storage::disk('public')->get($randomImage->imageUrl);
            // Route where we will save the image
            $resultPath = $user->getStorageDirName() . DIRECTORY_SEPARATOR
                . round(microtime(true) * 1000) . '.jpg';

            // Create dirs
            /*if (! File::exists(storage_path($user->getStorageDirName()))) {
                File::makeDirectory(storage_path($user->getStorageDirName()), 0755, true);
            }*/

            // Build the user's avatar url
            $avatarUrl = "https://graph.facebook.com/v3.0/{$user->facebookId}/picture?width=1000";

            // Avatar image
            $avatarImage = Image::make($avatarUrl)
                ->resize($quiz->avatarWidth, $quiz->avatarHeight)
                ->stream();

            // Base image
            $baseImage = Image::make($randomImage)
                // image, initial position, padding x, padding y
                ->insert($avatarImage, 'top-left', $quiz->avatarPositionX, $quiz->avatarPositionY)
                ->stream();

            // Result image
            $resultImage = Image::make($baseImage)
                ->insert($randomImage)
                ->encode('jpg', 75);

            // Save files
            Storage::disk('public')->put($resultPath, (string)$resultImage);

            // Check results
            if (Storage::disk('public')->exists($resultPath)) {
                $userQuiz = new UserQuiz([
                    'quiz_id' => $quiz->id,
                    'user_id' => $user->id,
                    'imageUrl' => $resultPath,
                    'imageSize' => $resultImage->filesize(),
                ]);

                if ($userQuiz->save()) {
                    $success = true;
                }
            }
        } catch (\Exception $exception) {
            $errorMsg = $exception->getMessage();
        }

        if ($success) {
            return response()->json([
                'status' => 'success',
                'url' => route('quiz.result', ['slug' => $slug, 'id' => $userQuiz->id])
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $errorMsg
            ], 500);
        }
    }

    public function quizResult($slug, $id)
    {
        $quiz = Quiz::where([['enabled', '=', true], ['slug', '=', $slug]])->firstOrFail();
        $userQuiz = UserQuiz::findOrFail($id);

        // Redirect to the original
        if (!Auth::check() || Auth::user()->id != $userQuiz->user_id) {
            return redirect()->route('quiz.show', ['slug' => $slug]);
        }

        // Replace helpers
        $quiz->resultTitle = str_replace('USERNAME', Auth::user()->name, $quiz->resultTitle);
        $quiz->resultDescription = str_replace('USERNAME', Auth::user()->name, $quiz->resultDescription);

        $quiz->resultTitle = str_replace('USERLASTNAME', Auth::user()->lastname, $quiz->resultTitle);
        $quiz->resultDescription = str_replace('USERLASTNAME', Auth::user()->lastname, $quiz->resultDescription);

        return view('quizzes.result', ['quiz' => $quiz, 'userQuiz' => $userQuiz]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        return view('quizzes.form', ['quiz' => $quiz]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        $quiz->update($request->all());
        $success = $quiz->save();

        if ($request->has('save') && $success) {
            return redirect()->route('quizzes.edit', [$quiz->id])
                ->with('success', __('¡Quiz guardado con éxito!'));
        } elseif ($request->has('saveNClose') && $success) {
            return redirect()->route('quizzes.index')
                ->with('success', __('¡Quiz guardado con éxito!'));
        } else {
            return back()->withInput()
                ->with('error', __('No se ha podido guardar el Quiz'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quiz $quiz
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Quiz $quiz)
    {
        UserQuiz::where('quiz_id', $quiz->id)->delete();
        $quiz->images()->delete();
        $quiz->delete();
        return redirect()->route('quizzes.index');
    }

    /**
     * Upload an image and associate to a quiz
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function uploadImage(Request $request) {
        $this->validate($request, [
            'file' => 'required|image|mimes:png|max:2048',
            'id' => 'required|integer'
        ]);

        $quiz = Quiz::findOrFail($request->input('id'));

        if ($quiz && $request->file('file')->isValid()) {

            $templatePath = $quiz->getTemplatesDirName() . DIRECTORY_SEPARATOR
                . round(microtime(true) * 1000) . '.png';

            // Create dirs
            /*if (! File::exists($quiz->getTemplatesDirName())) {
                File::makeDirectory(public_path($quiz->getTemplatesDirName()), 0755, true);
            }*/

            // Template image
            $templateImage = Image::make($request->file('file'))
                ->encode('png');

            // Save file
            Storage::disk('public')->put($templatePath, (string)$templateImage);

            $fileSize = $templateImage->filesize();

            if (Storage::disk('public')->exists($templatePath)) {
                $quizImage = new QuizImage([
                    'quiz_id' => $quiz->id,
                    'imageUrl' => $templatePath,
                    'imageSize' => $fileSize
                ]);

                if ($quizImage->save()) {
                    return response('success', 200);
                }
            }

            return response('error', 500);
        }
    }

    /**
     * Destroy an image from a quiz
     * @param QuizImage $quizImage
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroyImage(QuizImage $quizImage) {
        $quizImage->delete();
        return back();
    }
}
