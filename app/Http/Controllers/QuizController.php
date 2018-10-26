<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuiz;
use App\Quiz;
use App\QuizImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Image;

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
            $quiz = new Quiz();
            $quiz->title = $request->input('title');
            $quiz->slug = $request->input('slug');
            $quiz->description = $request->input('description');
            $quiz->resultTitle = $request->input('resultTitle');
            $quiz->resultDescription = $request->input('resultDescription');
            $quiz->avatarPositionX = $request->input('avatarPositionX');
            $quiz->avatarPositionY = $request->input('avatarPositionY');
            $quiz->enabled = $request->input('enabled');

            if ($quiz->save() && $request->file('coverImageUrl')->isValid()) {

                //setting flag for condition
                $org_img = $thm_img = true;

                // Create dirs
                if (! File::exists($quiz->getImageCoverPath())) {
                    File::makeDirectory(public_path($quiz->getImageCoverPath()), 0755, true);
                }
                if (! File::exists($quiz->getImageThumbPath())) {
                    File::makeDirectory(public_path($quiz->getImageThumbPath()), 0755, true);
                }


                Image::make($request->file('coverImageUrl'))
                    ->encode('jpg', 75)
                    ->save($quiz->getStorageDirName() . DIRECTORY_SEPARATOR . Quiz::COVER_IMAGE_NAME);
                Image::make($request->file('coverImageUrl'))
                    ->fit(300, 157)
                    ->encode('jpg', 75)
                    ->save($quiz->getStorageDirName() . DIRECTORY_SEPARATOR . Quiz::THUMB_IMAGE_NAME);

                $quiz->coverImageUrl = $quiz->getImageCoverPath();

                if ($quiz->save()) {
                    $success = true;
                }
            }
        } catch (\Exception $exception) {
            $success = false;
            var_dump($exception);
        }

        if ($request->has('save') && $success) {
            return redirect()->route('quiz.edit', [$quiz->id])
                ->with('success', __('¡Quiz guardado con éxito!'));
        } elseif ($request->has('saveNClose') && $success) {
            return redirect()->route('quizzes.index')
                ->with('success', __('¡Quiz guardado con éxito!'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        //
    }

    public function uploadImage(Request $request) {
        $this->validate($request, [
            'file' => 'required|image|mimes:png|max:2048',
            'id' => 'required|integer'
        ]);

        if ($request->file('file')->isValid()) {

            $fileExt = $request->file('file')->extension();
            $fileSize = $request->file('file')->getSize();
            $fileStoredPath = $request->file('file')->storeAs('quizzes'.DIRECTORY_SEPARATOR.'5', time().$fileExt);

            $quizImage = new QuizImage([
                'quiz_id' => $request->input('id'),
                'imageUrl' => asset($fileStoredPath),
                'imageSize' => $fileSize
            ]);
            $quizImage->save();

            return response('success', 200);
        }
    }
}
