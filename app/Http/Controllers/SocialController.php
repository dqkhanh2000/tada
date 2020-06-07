<?php

namespace App\Http\Controllers;

use App\Cart;
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
    protected $sessionIdBeforeLogin = null;
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

        $this->sessionIdBeforeLogin = Session::getId();
        return Socialite::driver($provider)->redirect();
    }


    public function findOrCreateUser($user, $provider)
    {
        $name = $user->user['family_name'].' '.$user->user['given_name'];
        $authUser = User::where('id_provider', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        $userDB = User::where('email', $user->email)->first();
        if($userDB == null){
            $userDB = new User;
            $userDB->email = $user->email;
            $userDB->provider_name = $provider;
            $userDB->id_provider = $user->id;
            $userDB->avatar = $user->avatar;
            $userDB->save();

            $customer = new Customer;
            $customer->customer_name = $name;
            $customer->id_user = $userDB->id;
            $customer->save();
        }

        return $userDB;
    }

    public function callback($provider){
        $getInfo = Socialite::driver($provider)->user();

        $user = $this->findOrCreateUser($getInfo,$provider);

        $customerID = $user->Customer()->get()->first()->id;

        Session::put("idCustomer", $customerID);
        $cart = Cart::where('id_session', $this->sessionIdBeforeLogin)->get();
        foreach($cart as $cartItem){
            $cartItem->id_customer = $customerID;
            $cartItem->save();
        }

        auth()->login($user);

        return redirect()->to(Session::get('pre_url'));

    }
}
