<?php


namespace App\Controllers;

use App\Components\View;


class IndexController extends BaseController
{
    public function index()
    {
        return View::render("index");
    }
}