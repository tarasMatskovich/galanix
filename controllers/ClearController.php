<?php


namespace App\Controllers;


use App\Models\User;
use App\Components\Session;

class ClearController extends BaseController
{
    public function index()
    {
        $users = User::get();
        foreach ($users as $user) {
            $user->delete();
        }
        Session::setFlash('success', [['All records was successfully deleted']]);
        header('Location: http://'.$_SERVER['HTTP_HOST']. "/");
    }
}