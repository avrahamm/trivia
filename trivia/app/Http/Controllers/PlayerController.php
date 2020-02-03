<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

use App\User;
use App\Helpers\QuestionHelper;

class PlayerController extends Controller
{
    /**
     * To display trivia login form.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loginForm()
    {
        return view('trivia.loginForm');
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
    public function saveUser(Request $request) : RedirectResponse
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
     * Returns a list of logged in users.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoggedInUsers()
    {
        // @link:https://stackoverflow.com/questions/15632144/laravel-get-currently-logged-in-users
        $lifetime = config('session.lifetime', 120);
        $loggedInUsers = User::where('updated_at', '>',
            Carbon::now()->subMinutes($lifetime))->get();
        return view('trivia.loggedInUsers', ['users' => $loggedInUsers]);
    }
}
