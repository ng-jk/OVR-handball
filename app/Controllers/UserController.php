<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Auth;
use App\Libraries\Password;
use App\Models\Admin;

class UserController extends BaseController
{
    public function toHome()
    {
        return redirect('home');
    }
    public function logoutHandler()
    {
        Auth::forget();
        return redirect('login')->with('success','logout success');
    }
}
