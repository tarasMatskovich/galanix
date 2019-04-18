<?php


namespace App\Controllers;

use App\Components\View;
use App\Models\User;


class ResultController extends BaseController
{
    public function index()
    {
        $filters = $_GET;
        if (isset($filters['path']))
            unset($filters['path']);
        $params = [];
        foreach ($filters as $field => $value) {
            if ($value != '') {
                $arr = [];
                if ($field == 'gender' || $field == 'age') {
                    $arr = [
                        'operator' => '=',
                        'value' => $value
                    ];
                } else {
                    $arr = [
                        'operator' => "LIKE",
                        'value' => "%" . $value . "%"
                    ];
                }
                $params[$field] = $arr;
            }
        }
        $users = User::where($params)::get();
        return View::render('view', [
            'users' => $users
        ]);
    }
}