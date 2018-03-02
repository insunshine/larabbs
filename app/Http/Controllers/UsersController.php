<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;

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

    //更新资料
    public function update(UserRequest $request, ImageUploadHandler $upload, User $user){
        $data = $request->all();

        if ($request->avatar) {
            $result = $upload->save($request->avatar, 'avatar', $user->id, 362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '成功更新自认资料');
    }
}
