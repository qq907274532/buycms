<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Services\HelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function setting(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('account.profile', ['user' => Auth::user()]);
        }

        $data = $this->validate($request, [
            'password' => 'nullable|min:6',
            'phone' => 'nullable|digits:11',
            'email' => 'nullable|email',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        Auth::user()->update($data);
        HelperService::adminLog(true, '修改资料', Auth::user()->id);
        return $this->success();
    }
}
