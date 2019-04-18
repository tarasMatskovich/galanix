<?php


namespace App\Controllers;

use App\Components\View;
use App\Models\User;


class ResultController extends BaseController
{
    public function index()
    {
        $users = User::get();
        return View::render('view', [
            'users' => $users
        ]);
    }
}