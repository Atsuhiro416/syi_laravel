<?php

namespace App\Http\Controllers;

use App\Http\Requests\FolderRequest;
use App\Models\Folder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FolderController extends Controller
{
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
}