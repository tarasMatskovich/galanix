<?php


namespace App\Controllers;

use App\Components\View;


class ResultController extends BaseController
{
    public function index()
    {
        return View::render('view');
    }
}