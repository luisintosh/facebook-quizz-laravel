<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuiz;
use App\Quiz;
use App\QuizImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
            $quiz = new Quiz([
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description'),
                'resultTitle' => $request->input('resultTitle'),
                'resultDescription' => $request->input('resultDescription'),
                'avatarPositionX' => $request->input('avatarPositionX'),
                'avatarPositionY' => $request->input('avatarPositionY'),
                'enabled' => $request->input('enabled'),
            ]);

            if ($request->file('coverImage')->isValid()) {

                $coverPath = $quiz->getStorageDirName() . DIRECTORY_SEPARATOR . Quiz::COVER_IMAGE_NAME;
                $thumbPath = $quiz->getStorageDirName() . DIRECTORY_SEPARATOR . Quiz::THUMB_IMAGE_NAME;

                // Create dirs
                if (! File::exists($quiz->getStorageDirName())) {
                    File::makeDirectory(public_path($quiz->getStorageDirName()), 0755, true);
                }

                // Cover image
                Image::make($request->file('coverImage'))
                    ->encode('jpg', 75)
                    ->save($coverPath);

                // Thumb image
                Image::make($request->file('coverImage'))
                    ->fit(300, 157)
                    ->encode('jpg', 75)
                    ->save($thumbPath);

                // Check results
                if (File::exists($coverPath) && File::exists($thumbPath)) {
                    $quiz->coverImage = asset($coverPath);
                    $quiz->thumbImage = asset($thumbPath);

                    if ($quiz->save()) {
                        $success = true;
                    }
                }
            }
        } catch (\Exception $exception) { }

        if ($request->has('save') && $success) {
            return redirect()->route('quizzes.edit', [$quiz->id])
                ->with('success', __('¡Quiz guardado con éxito!'));
        } elseif ($request->has('saveNClose') && $success) {
            return redirect()->route('quizzes.index')
                ->with('success', __('¡Quiz guardado con éxito!'));
        } else {
            return redirect()->back()
                ->with('error', __('No se ha podido guardar la imagen'));
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
