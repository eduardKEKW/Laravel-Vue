<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class OptionController extends Controller
{

    /**
     * Store a new option for a certain question
     *
     * @param  Question  $question
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request, Question $question)
    {
        [ 'name' => $name ] = $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $question->options()->create([
            'name' => $name
        ]);

        return response()->json([
            'success'   => true,
            'question'  => $question
        ]);
    }

    /**
     * Delete the option.
     *
     * @param   Question  $question
     * @param   Option $option
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Request $request, Option $option)
    {
        $question = $option->question;

        // make sure the question was created by the auth user
        if (auth()->user()->id !== $question->user_id) {
            return response(null, 401);
        }

        $success = $option->delete();

        return response()->json([
            'success'   => $success,
            'question'  => $question
        ]);
    }


    /**
     * Lets an user vote on a option that belogs to a question.
     *
     * @param  Option  $option
     * @return \Illuminate\Http\Response
     */
    public function vote(Request $request, Option $option)
    {
        $vote = $request->user()->voteOn($option);

        return response()->json([
            'success'   => true,
            'vote'      => $vote
        ]);
    }
}
