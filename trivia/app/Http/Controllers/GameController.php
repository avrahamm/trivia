<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Helpers\QuestionHelper;

class GameController extends Controller
{
    /**
     * Displays game form.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function displayForm(Request $request)
    {
        $question = QuestionHelper::getValidQuestion();
        $gameMessage = $request->input('gameMessage') ?: '';
        return view('trivia.game', compact('question', 'gameMessage'));
    }

    /**
     * Checks answer, creates appropriate game message
     * and redirects.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkAnswer(Request $request)
    {
        $request->validate([
            'questionId' => 'required|numeric',
            'answer' => 'required|max:500'
        ]);
        $submittedQuestionId = $request->input('questionId');
        if ( !QuestionHelper::isSubmittedQuestionValid((int)$submittedQuestionId)) {
            return redirect()->route('game.form',['gameMessage' => 'Your Question was Updated. Good Luck!']);
        }

        $answer = $request->input('answer');
        if ( QuestionHelper::isAnswerCorrect($answer)) {
            $gameMessage = "Answer is correct! Enjoy next question!";
            return redirect()->route('question.create',['gameMessage' => $gameMessage]);
        }

        $gameMessage = "Answer is wrong! Keep on trying!";
        return redirect()->route('game.form',compact('gameMessage'))->withInput();
    }

}
