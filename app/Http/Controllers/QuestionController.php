<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Answear;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;

class QuestionController extends Controller
{

    public function __constructor()
    {

    }


    public function index (Request $req)
    {
        return QuestionResource::collection(Question::all());
    }

    public function vote (Request $request, Question $question)
    {

        $user_id = $request->user()->id;

        Answear::updateOrCreate(
            [ 'user_id' => $user_id ],
            [ 'question_id' => $question->id ]
        );

        return response()->json([
            'success'   => true,
            'question'  => new QuestionResource($question),
        ]);
    }

}
