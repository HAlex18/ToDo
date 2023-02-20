<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ToDoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //Home
    public function index()
    {  

        $folders = Folder::where('user_id', '=', Auth::id())->get();

        return view('home', [
            'folders' => $folders,
        ]);
    }

    //selectFolders
    public function selectFolders($id){

        $folders = Folder::all();

        $folders_id = Folder::find($id);
        $current_folder_id = $folders_id->id;
        $todos = Todo::where('folder_id', '=', $current_folder_id)->get();

        return view('home', [
            'folders' => $folders,
            'current_folder_id' => $id,
            'todos' => $todos,
        ]);
    }

    //Show TodoCreateForms
    public function showCreateForm($id)
    {  

        return view('/todos/create',[
            'current_folder_id' => $id,
        ]);
    }

    //Add tasks
    public function create(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'content' => 'required|max:100',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        if($validator->fails()) {

            return redirect()->action([ToDoController::class, 'create'], ['id' => $id])->withErrors($validator);
        };

        $todos = new Todo();
        $todos->folder_id = $request->folder_id;
        $todos->content = $request->content;
        $todos->due_date = $request->due_date;
        $todos->save();

        return redirect('/home')->with('flash_message', 'タスクを登録しました。');
    }

    public function showEditForm($id) {

        $todos = Todo::find($id);

        return view('/todos/edit', compact('todos'));

    }

    public function edit(Request $request, $id)
    {
        $inputs = $request->all();

        $validator = Validator::make($request->all(), [
            'content' => 'required|max:100',
            'status' => 'required',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        if($validator->fails()) {

            return redirect()->action([ToDoController::class, 'edit'], ['id' => $id])->withErrors($validator)->with($inputs);
        }

        $todos = Todo::find($id);
        $todos->fill($inputs)->save();

        return redirect('/home')->with('flash_message', 'タスクを編集しました。');
    }

    public function delete($id)
    {
        $todos = Todo::find($id);
        $todos->delete();

         return redirect('/home')->with('flash_message', 'タスクを削除しました。');
    }

}
