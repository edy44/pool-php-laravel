<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view("admin.users.index", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|max:255',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|min:8|required_with:password_confirm|same:password_confirm',
            'password_confirm' => 'min:8',
        ]);
        $hash = password_hash($request->get('password'), PASSWORD_DEFAULT);
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = $hash;
        $user->admin = $request->get('admin');
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();
        return redirect('/admin/users')->with('success','Nouvel utilisateur ajouté');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
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
        $request->validate([
            'name' => 'bail|required|max:255',
            'email' => [
                'bail',
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
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
        $user->admin = $request->get('admin');
        $user->updated_at = Carbon::now();
        $user->save();
        return redirect('/admin/users')->with('success','Utilisateur modifié');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete($id);
        return redirect('/admin/users')->with('danger','Utilisateur supprimé');
    }
}
