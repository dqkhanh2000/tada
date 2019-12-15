<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class SocialController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        if(!Session::has('pre_url')){
            Session::put('pre_url', URL::previous());
        }else{
            if(URL::previous() != URL::to('login')) Session::put('pre_url', URL::previous());
        }
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Lấy thông tin từ Provider, kiểm tra nếu người dùng đã tồn tại trong CSDL
     * thì đăng nhập, ngược lại nếu chưa thì tạo người dùng mới trong SCDL.
     *
     * @return Response
     */

    public function findOrCreateUser($user, $provider)
    {
        $name = $user->user['family_name'].' '.$user->user['given_name'];
        $authUser = User::where('ProviderID', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        $userDB = User::where('email', $user->email)->first();
        if($userDB == null){
            $userDB = new User;
            $userDB->email = $user->email;
            $userDB->ProviderName = $provider;
            $userDB->ProviderID = $user->id;
            $userDB->Avatar = $user->avatar;
            $userDB->save();

            $customer = new Customer;
            $customer->CustomerName = $name;
            $customer->UserID = $userDB->id;
            $customer->save();
        }

        return $userDB;
    }

    public function callback($provider){
        $getInfo = Socialite::driver($provider)->user();

        $user = $this->findOrCreateUser($getInfo,$provider);

        auth()->login($user);

        return redirect()->to(Session::get('pre_url'));

    }
}
