<?php

namespace App\Http\Controllers;

use App\Models\Vote;
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
        $this->middleware('auth:api', ['only' => ['create', 'store', 'update', 'destroy']]);
    }

    /**
     * Get a list of all questions.
     *
     * @return QuestionResource
     */
    public function index()
    {
        return Question::all()->load('user');
        return QuestionResource::collection(Question::all()->load('user'));
    }

    /**
     * Get a single question and all data associated with it.
     *
     * @param   Request $request
     * @param   Question $question
     * @return  \Illuminate\Http\Response
     */
    public function single(Request $request, Question $question)
    {
        $option_id = null;

        // get question with options and number of votes for every option
        $question->load(
            [
                'options' => function ($query) {
                    $query->select(['question_id', 'name', 'id']);
                    $query->withCount('votes');
                },
                'user' => function ($query) {
                    $query->select(['id', 'name']);
                },
            ]
        )->get();

        // if the user has already voted on this question
        if (auth()->user()) {
            $option_id = Vote::where([
                'question_id' => $question->id,
                'user_id'     => auth()->user()->id
            ])->get('option_id');
        }

        return response()->json([
            'question'      => $question,
            'user_vote_on'  => $option_id,
        ]);
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

        // the assoc options will be deleted with the sql constrained
        // and also the votes
        $success = $question->delete();

        return response()->json([
            'success' => $success,
        ]);
    }
}
