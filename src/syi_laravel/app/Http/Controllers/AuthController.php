<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        try {
            $data = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'api_token' => null,
            ]);
            if ($data) {
                $message = 'ユーザーを登録しました';
                $status = 201;
            }
        } catch (\Exception $e) {
            //throw $th;
            $message = 'ユーザー登録に失敗しました';
            $data = $e;
            $status = 500;
        } finally {
            return response()->json([
                'message' => $message,
                'data' => $data,
            ], $status);
        }
    }

    public function login (Request $request)
    {
        $isAuth = false;

        try {
            $user = User::where('email', $request->email)->first();
            //メールアドレスが存在すればパスワードチェック
            if ($user) {
                if(Hash::check($request->password, $user->password)){
                    //パスワードが正しければトークン生成
                    $user->api_token = Str::random(80);
                    $user->save();
                    $data = $user;
                    $isAuth = true;
                    $message = 'ログインしました';
                    $status = 200;
                } else {
                    $message = 'パスワードが間違っています';
                    $data = null;
                    $status = 401;
                }
            } else {
                $message = 'メールアドレスが間違っているか存在しません';
                $data = null;
                $status = 404;
            }
        } catch (\Exception $e) {
            //throw $th;
            $message = 'ログインに失敗しました';
            $data = $e;
            $status = 500;
        } finally {
            return response()->json([
                'message' => $message,
                'data' => $data,
                'auth' => $isAuth,
            ], $status);
        }
    }

    public function logout (Request $request)
    {
        $user = User::find($request->id);
        $user->api_token = null;
        $user->save();
        return response()->json([
            'message' => 'ログアウトしました',
            'auth' => false,
        ], 200);
    }
}
