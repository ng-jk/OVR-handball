<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Auth;
use App\Libraries\Password;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $helper = ['url','form'] ;
    public function loginForm()
    {
        $data = [
            'pageTitle'=>'login',
            'validation'=>null
        ];
        return view('pages/auth/login', $data);
    }
    public function loginHandler()
    {
        $isValid = $this->validate([
            'username'=> [
                'rules'=>'required|is_not_unique[users.username]',
                'errors'=> [
                    'required'=> 'enter username',
                    'is_not_unique'=> 'username not exist',
                ],
            ],
            'password'=> [
                'rules'=>'required',
                'errors'=> [
                    'required'=> 'enter password',
                ],
            ],
        ]) ;

        if (!$isValid) {
            return view('pages/auth/login',[
                'pageTitle'=>'login',
                'validation'=>$this->validator
            ]);
        }else{
            $user = new UserModel();
            $userInfo = $user->where('username', $this->request->getVar('username'))->first();
            $correctPassword = Password::check($this->request->getVar('password'), $userInfo['password']);

            if (!$correctPassword) {
                return redirect()->route('login')->with('fail','wrong password')->withInput();
            }else{
                Auth::setAuth($userInfo);
                return redirect()->route('home');
            }
        }
    }
    public function toLogin(){
        return redirect()->route('login');
    }
}
