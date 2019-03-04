<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('pages.register');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required',

        ]);
        $user = User::add($request->all());
        $user->generatePassword($request->get('password'));

        return redirect('/login');
    }

    public function loginForm()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (\Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ])) {
            return redirect('/');
        }

        return redirect()->back()->with('status', 'Не верный логин или пароль!');
    }

    public function logout()
    {
        \Auth::logout();

        return redirect('/login');
    }

    public function profileShow()
    {
        return view('pages.profile');
    }

    public function profileUpdate(Request $request)
    {
        $user = User::find(\Auth::user()->id);

        $this->validate($request, [
            'name'  => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'avatar' => 'nullable',
        ]);

        $user->edit($request->all());
        $user->generatePassword($request->get('password'));
        $user->uploadAvatar($request->file('avatar'));

        return redirect()->route('post.index');
    }

    public function comment(Request $request)
    {
        $this->validate($request, [
            'massage' => 'require',
        ]);

        $comment = new Comment();
        $comment->text = $request->get('message');
        $comment->post_id = $request->get('post_id');
        $comment->user_id = Auth::user()->id;
        $comment->save();

        return redirect()->back()->with('stastus', 'Ваш комментарий отправлен!');
    }
}
