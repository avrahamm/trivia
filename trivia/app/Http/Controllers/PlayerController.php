<?php

namespace App\Http\Controllers;

use App\Helpers\QuestionHelper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends Controller
{
    /**
     * To display trivia login form.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loginForm()
    {
        return view('trivia.login');
    }

    /**
     * Creates new user with submitted user name,
     * the is logged in,
     * new question is generated if needed,
     * and redirects.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveUser(Request $request)
    {
        $request->validate([
            'username' => 'required|alpha_num|min:2|max:10|',
        ]);
        $username = $request->input('username');
        $user = factory(User::class)->create([
            'name' => $username,
        ]);

        Auth::login($user);

        if( QuestionHelper::hasValidQuestion()) {
            return redirect()->route('game.form');
        }
        //  first redirect to create new question,
        return redirect()->route('question.create');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // @link:https://stackoverflow.com/questions/15632144/laravel-get-currently-logged-in-users
        $loggedInPlayers = [];
    }
}
