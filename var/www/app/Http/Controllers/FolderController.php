<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FolderController extends Controller
{
    public function showCreateForm($user) {

        $user = User::find($user);

        return view('/folders/create', [
            'user' => $user,
        ]);
    }

    public function create(Request $request) {

        $inputs = $request->all();
        $user = User::find(Auth::id());

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:20',
        ]);

        if($validator->fails()) {

            return redirect()->action([FolderController::class, 'showCreateForm'], ['user' => $user->id])->withErrors($validator)->withInput($inputs);

        }

        $folder = new Folder();
        $folder->user_id = $request->user_id;
        $folder->title = $request->title;
        $folder->save();

        return redirect('/index')->with('folders_flash_message', 'フォルダを作成しました。');
    }


    public function delete($user, $id) {

        $folder = Folder::where('user_id', '=', $user)
            ->where('id', '=', $id);
        $folder->delete();

        $todos = Todo::where('folder_id', '=', $id);
        $todos->delete();

        return redirect('/index')->with('folders_flash_message', 'フォルダを削除しました。');

    }

}
