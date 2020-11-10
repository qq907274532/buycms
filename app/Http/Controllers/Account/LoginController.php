<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use RedirectsUsers;

    public function getLogin()
    {
        return view('account.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $this->validate($request, [
            $this->username()   => 'required|string',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);


        $user = AdminUser::where($this->username(), $credentials[$this->username()])->first();

        if (empty($user) || Hash::check($credentials['password'], $user->getAuthPassword()) === false) {
            return back()->withErrors([$this->username() => '用户名或密码不正确.']);
        }


        if ($user['status'] == AdminUser::STATUS_DISABLE) {
            return back()->withErrors([$this->username() => '用户已被禁用，请联系管理员.']);
        }
        if ($user['is_delete'] == AdminUser::IS_DELETE) {
            return back()->withErrors([$this->username() => '用户已被删除.']);
        }


        //update login ip and login time
        $user->update([
            'last_login_ip'   => $request->ip(),
            'last_login_time' => date('Y-m-d H:i:s'),
        ]);

        Auth::guard()->login($user, $request->filled('remember_me'));
        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath());
    }



    public function getLogout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }

    public function redirectTo()
    {
        return '/';
    }

    public function username()
    {
        return 'username';
    }


}
