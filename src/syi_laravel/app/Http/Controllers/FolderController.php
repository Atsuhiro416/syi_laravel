<?php

namespace App\Http\Controllers;

use App\Http\Requests\FolderRequest;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Http\Request;

class FolderController extends Controller
{

    public function __construct(Folder $folder)
    {
        $this->folder = $folder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = Folder::all();
        return response()->json([
            'message' => 'フォルダー一覧を取得しました。',
            'data' => $folders,
        ], 200);
    }


    public function indexUsersFolders($user_id)
    {
        $folders = User::find($user_id)->folders;
        return response()->json([
            'message' => 'リスト一覧です。',
            'data' => $folders,
        ], 200);
    }

    public function getUserFolderCounts($user_id)
    {
        $folders = User::find($user_id)->folders->count();
        return response()->json([
            'message' => 'フォルダー数を取得しました。',
            'counts' => $folders,
        ], 200);
    }

    public function indexFoldersStacks($folder_id)
    {
        $foldersStacks = Folder::find($folder_id)->stacks()->get();
        return response()->json([
            'message' => 'フォルダー内リストを一覧取得しました。',
            'data' => $foldersStacks,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FolderRequest $request)
    {
        $folder = Folder::create($request->all());
        return response()->json([
            'message' => 'フォルダーを作成しました。',
            'data' => $folder,
        ], 201);
    }

    public function attachStackToFolder($folder_id, $stack_id)
    {
        $isFolderStack = $this->folder->isExistsFolderStack($folder_id, $stack_id);
        //リレーションがすでに存在していた場合はコンフリクトを通知
        if ($isFolderStack) {
            return response()->json([
                'message' => 'リストはすでに該当のフォルダーに入っています。',
            ], 409);
        }
        $folder = Folder::find($folder_id);
        $folder->stacks()->attach($stack_id);
        return response()->json([
            'message' => 'リストをフォルダーに追加しました。',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function show(Folder $folder)
    {
        return response()->json([
            'message' => 'フォルダー詳細取得',
            'data' => $folder,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(FolderRequest $request, Folder $folder)
    {
        $folder->fill($request->all())->save();
        return response()->json([
            'message' => 'フォルダーを更新しました。',
            'data' => $folder,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        $folder->delete();
        return response()->json([
            'message' => 'フォルダーを削除しました。',
        ], 200);
    }

    public function detachStackToFolder($folder_id, $stack_id)
    {
        $folder = Folder::find($folder_id);
        $folder->stacks()->detach($stack_id);
        return response()->json([
            'message' => 'リストをフォルダーから削除しました。',
        ], 200);
    }
}
