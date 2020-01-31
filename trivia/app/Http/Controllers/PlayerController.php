<?php

namespace App\Http\Controllers;

use App\Helpers\QuestionHelper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends Controller
{
    public function login()
    {
//        return redirect()->route('login');
        return view('trivia.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveUser(Request $request)
    {
//        dd('saveUser');

        $request->validate([
            'username' => 'required|alpha_num|min:2|max:10|',
        ]);
        $username = $request->input('username');
        $user = factory(User::class)->create([
            'name' => $username,
        ]);
        Auth::login($user);
//        if( $question = QuestionHelper::getValidQuestion())
        // if valid question exists,
        //      get it,
        //      return redirect()->route('game.form');
        //else
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
