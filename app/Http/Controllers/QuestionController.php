<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\QuestionStoreRequest;
use App\Http\Requests\UpdateQuestionRequest;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['create']]);
    }

    /**
     * Get a list of all questions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QuestionResource::collection(Question::all());

        return Question::withCount('answears')->get();

    }

    /**
     * Create the question and the associated options with it.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionStoreRequest $request)
    {
        $validated  = $request->validated();
        $creator_id = $request->user()->id;

        ['options' => $options, 'name' => $question_name] = $validated;

        // create question
        $question = Question::create([
            'name'      => $question_name,
            'user_id'   => $creator_id
        ]);

        // create options through question
        $question->options()->createMany(
            array_map(function ($opt) {
                return ['name' => $opt];
            }, $options)
        );

        return response()->json([
            'success'   => true,
            'question'  => $question
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateQuestionRequest  $request
     * @param  Question $question
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $success = $question->update([
            'name' => $request->get('name')
        ]);

        return response()->json([
            'success'   => $success,
            'question'  => $question->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   Request $request
     * @param   Question $question
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Request $request, Question $question)
    {
        // make sure the question was created by the auth user
        if (auth()->user()->id !== $question->user_id) {
            return response(null, 401);
        }

        $success = $question->delete();

        return response()->json([
            'success' => $success,
        ]);
    }
}
