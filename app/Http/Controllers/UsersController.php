<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //用户资料展示
    public function show(User $user){
        return view('users.show', compact('user'));
    }

    //修改页面
    public function edit(User $user){
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user){
        $user->update($request->all());
        return redirect()->route('users.show', $user->id)->with('success', '成功更新自认资料');
    }
}
