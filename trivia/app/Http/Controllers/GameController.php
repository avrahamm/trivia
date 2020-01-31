<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Helpers\QuestionHelper;

class GameController extends Controller
{
    public function displayForm(Request $request)
    {
//        $question = Question::latest()->first();
        $question = Question::first(); // TEMP
        $gameMessage = $request->input('gameMessage') ?: '';
        return view('trivia.game', compact('question', 'gameMessage'));
    }

    public function checkAnswer(Request $request)
    {
        $request->validate([
            'questionId' => 'required|numeric',
            'answer' => 'required|max:500'
        ]);
        $curQuestion = Question::latest()->first();
        if ( !QuestionHelper::isSubmittedQuestionValid($request, $curQuestion)) {
            return redirect()->route('game.form',['gameMessage' => 'Your Question was Updated. Good Luck!']);
        }

        if ( QuestionHelper::isAnswerCorrect($request,$curQuestion)) {
            $gameMessage = "Answer is correct! Enjoy next question!";
            return redirect()->route('question.create',['gameMessage' => $gameMessage]);
        }

        $gameMessage = "Answer is wrong! Keep on trying!";
        return redirect()->route('game.form',compact('gameMessage'))->withInput();
    }

}
