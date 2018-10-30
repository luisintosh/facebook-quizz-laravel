<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuiz;
use App\Quiz;
use App\QuizImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class QuizController extends Controller
{
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

                // Create dirs
                if (! File::exists(storage_path($quiz->getStorageDirName()))) {
                    File::makeDirectory(storage_path($quiz->getStorageDirName()), 0755, true);
                }

                // Cover image
                $coverImage = Image::make($request->file('coverImage'))
                    ->encode('jpg', 75);

                // Thumb image
                $thumbImage = Image::make($request->file('coverImage'))
                    ->fit(300, 157)
                    ->encode('jpg', 75);

                // Save files
                Storage::disk('public')->put($coverPath, (string)$coverImage);
                Storage::disk('public')->put($thumbPath, (string)$thumbImage);

                // Check results
                if (Storage::disk('public')->exists($coverPath) && Storage::disk('public')->exists($thumbPath)) {
                    $quiz->coverImage = Storage::disk('public')->url($coverPath);
                    $quiz->thumbImage = Storage::disk('public')->url($thumbPath);

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
    public function show(Quiz $quiz)
    {
        //
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
        $quiz->images()->delete();
        $quiz->delete();
        return redirect()->route('quizzes.index');
    }

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
            if (! File::exists($quiz->getTemplatesDirName())) {
                File::makeDirectory(public_path($quiz->getTemplatesDirName()), 0755, true);
            }

            // Template image
            $templateImage = Image::make($request->file('file'))
                ->encode('png');

            // Save file
            Storage::disk('public')->put($templatePath, (string)$templateImage);

            $fileSize = $templateImage->filesize();

            if (Storage::disk('public')->exists($templatePath)) {
                $quizImage = new QuizImage([
                    'quiz_id' => $quiz->id,
                    'imageUrl' => Storage::disk('public')->url($templatePath),
                    'imageSize' => $fileSize
                ]);

                if ($quizImage->save()) {
                    return response('success', 200);
                }
            }

            return response('error', 500);
        }
    }

    public function destroyImage(QuizImage $quizImage) {
        $quizImage->delete();
        return back();
    }
}
