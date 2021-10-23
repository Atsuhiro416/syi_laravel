<?php

namespace App\Http\Controllers;

use App\Http\Requests\StackRequest;
use App\Models\Stack;
use App\Models\User;
use Illuminate\Http\Request;

class StackController extends Controller
{

    public function __construct(Stack $stack)
    {
        $this->stack = $stack;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = Stack::all();
        return response()->json([
            'message' => 'リストを全件取得しました',
            'data' => $item,
        ], 200);
    }

    public function indexUsersStacks($user_id)
    {
        $stacks = User::find($user_id)->stacks;
        return response()->json([
            'message' => 'リスト一覧です。',
            'data' => $stacks,
        ], 200);
    }

    public function getUserStackCounts($user_id)
    {
        $stacks = User::find($user_id)->stacks->count();
        return response()->json([
            'message' => 'リスト数を取得しました。',
            'counts' => $stacks,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StackRequest $request)
    {
        $stack = Stack::create($request->all());
        return response()->json([
            'message' => 'リストを作成しました。',
            'data' => $stack,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stack  $stack
     * @return \Illuminate\Http\Response
     */
    public function show(Stack $stack)
    {
        $item = $this->stack->showStackWithRelatedFolder($stack->id);
        if ($item) {
            return response()->json([
                'message' => 'リスト詳細を取得しました。',
                'data' => $item,
            ], 200);
        } else {
            return response()->json([
                'message' => '該当するリストが存在しません。',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stack  $stack
     * @return \Illuminate\Http\Response
     */
    public function update(StackRequest $request, Stack $stack)
    {
        $stack->fill($request->all())->save();
        return response()->json([
            'message' => 'リストを更新しました。',
            'data' => $stack,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stack  $stack
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stack $stack)
    {
        $stack->delete();
        return response()->json([
            'message' => '該当するリストを削除しました。',
        ], 200);
    }
}
