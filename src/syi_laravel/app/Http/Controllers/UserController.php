<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = User::all();
            $message = 'ユーザー全件取得しました';
            $status = 200;
        } catch (\Exception $e) {
            // throw $e;
            $message = 'ユーザー全件取得に失敗しました';
            $data = $e;
            $status = 500;
        } finally {
            return response()->json([
                'message' => $message,
                'data' => $data,
            ], $status);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        try {
            $data = User::find($user->id);
            $message = '該当ユーザーを取得しました';
            $status = 200;
        } catch (ModelNotFoundException $e) {
            $message = '該当するユーザーが存在しません';
            $data = $e;
            $status = 404;
        } catch (\Exception $e) {
            //throw $th;
            $message = '該当ユーザー情報取得に失敗しました';
            $data = $e;
            $status = 500;
        } finally {
            return response()->json([
                'message' => $message,
                'data' => $data,
            ], $status);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {
            $user = User::find($user->id);
            $user->fill([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'api_token' => $user->api_token,
            ])->save();

            $message = 'ユーザー情報を更新しました';
            $data = $user;
            $status = 200;
        } catch (ModelNotFoundException $e) {
            $message = '該当するユーザーが存在しません';
            $data = $e;
            $status = 404;
        } catch (\Exception $e) {
            //throw $th;
            $message = '該当ユーザー情報の更新に失敗しました';
            $data = $e;
            $status = 500;
        } finally {
            return response()->json([
                'message' => $message,
                'data' => $data,
            ], $status);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            User::find($user->id)->delete();
            $message = 'ユーザーを削除しました';
            $data = null;
            $status = 200;
        } catch (ModelNotFoundException $e) {
            $message = '該当するユーザーが存在しません';
            $data = $e;
            $status = 404;
        } catch (\Exception $e) {
            //throw $th;
            $message = '該当ユーザーの削除に失敗しました';
            $data = $e;
            $status = 500;
        } finally {
            return response()->json([
                'message' => $message,
                'data' => $data,
            ], $status);
        }
    }
}
