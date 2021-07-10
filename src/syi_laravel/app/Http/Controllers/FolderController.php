<?php

namespace App\Http\Controllers;

use App\Models\Folder;
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
    public function store(Request $request)
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
        $item = Folder::find($folder->id);
        return response()->json([
            'message' => 'フォルダー詳細取得',
            'data' => $item,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Folder $folder)
    {
        $item = Folder::find($folder->id);
        if ($item) {
            $item->fill($request->all())->save();
            return response()->json([
                'message' => 'リストを更新しました。',
                'data' => $item,
            ], 200);
        } else {
            return response()->json([
                'message' => '該当するリストが存在しません。',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        $item = Folder::destroy($folder->id);
        if ($item) {
            return response()->json([
                'message' => 'フォルダーを削除しました。',
            ], 200);
        } else {
            return response()->json([
                'message' => '該当するフォルダーがありません。',
            ], 404);
        }
    }
}
