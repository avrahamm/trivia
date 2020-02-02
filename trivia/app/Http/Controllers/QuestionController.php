<?php

namespace App\Http\Controllers;

use App\Helpers\QuestionHelper;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * To generate new valid question and redirect to game form.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        QuestionHelper::generateNewValidQuestion();
        return redirect()->route('game.form', ['gameMessage' => $request->input('gameMessage')]);
    }
}
