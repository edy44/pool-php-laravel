<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $id = Auth::id();
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($user->balance)
        {
            $balance = $user->balance;
        }
        else
        {
            $balance = 0;
        }
        $request->validate([
            'name' => 'bail|required|max:255',
            'email' => [
                'bail',
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'balance' => 'numeric',
            'password' => 'bail|sometimes|nullable|min:8|same:password_confirm',
            'password_confirm' => 'bail|sometimes|nullable|min:8',
        ]);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        if ($request->get('password'))
        {
            $hash = password_hash($request->get('password'), PASSWORD_DEFAULT);
            $user->password = $hash;
        }
        if ($request->get('balance'))
        {
            $user->balance = $balance + $request->get('balance');
        }
        $user->updated_at = Carbon::now();
        $user->save();
        return redirect('/profil')->with('success','Profil modifié');
    }

}
