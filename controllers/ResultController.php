<?php


namespace App\Controllers;

use App\Components\View;
use App\Models\User;


class ResultController extends BaseController
{
    public function index()
    {
        $filters = [];
        if (isset($_GET['filter'])) {
            $filters = $_GET['filter'];
        }
        if (isset($_GET['order'])) {
            if ($_GET['order']['type'] == 'asc') {
                // then desc
                if (!empty($filters)) {
                    $nameOrderLink = $_SERVER['HTTP_HOST'] . '/view';
                    $nameOrderLink .= "?";
                    $ageOrderLink = $_SERVER['HTTP_HOST'] . '/view';
                    $ageOrderLink .= "?";
                    $emailOrderLink = $_SERVER['HTTP_HOST'] . '/view';
                    $emailOrderLink .= "?";
                    $phoneOrderLink = $_SERVER['HTTP_HOST'] . '/view';
                    $phoneOrderLink .= "?";
                    $genderOrderLink = $_SERVER['HTTP_HOST'] . '/view';
                    $genderOrderLink .= "?";
                    foreach ($filters as $field => $filter) {
                        $nameOrderLink .= "filter[" . $field . "]=" . $filter . "&";
                        $ageOrderLink .= "filter[" . $field . "]=" . $filter . "&";
                        $emailOrderLink .= "filter[" . $field . "]=" . $filter . "&";
                        $phoneOrderLink .= "filter[" . $field . "]=" . $filter . "&";
                        $genderOrderLink .= "filter[" . $field . "]=" . $filter . "&";
                    }
                    $nameOrderLink .= "order[name]=name&order[type]=desc";
                    $ageOrderLink .= "order[name]=age&order[type]=desc";
                    $emailOrderLink .= "order[name]=email&order[type]=desc";
                    $phoneOrderLink .= "order[name]=phone&order[type]=desc";
                    $genderOrderLink .= "order[name]=gender&order[type]=desc";
                } else {
                    $nameOrderLink = $_SERVER['HTTP_HOST'] . '/view' . "?order[name]=name&order[type]=desc";
                    $ageOrderLink = $_SERVER['HTTP_HOST'] . '/view' . "?order[name]=age&order[type]=desc";
                    $emailOrderLink = $_SERVER['HTTP_HOST'] . '/view' . "?order[name]=email&order[type]=desc";
                    $phoneOrderLink = $_SERVER['HTTP_HOST'] . '/view' . "?order[name]=phone&order[type]=desc";
                    $genderOrderLink = $_SERVER['HTTP_HOST'] . '/view' . "?order[name]=gender&order[type]=desc";
                }
            } else {
                // then asc
                if (!empty($filters)) {
                    $nameOrderLink = $_SERVER['HTTP_HOST'] . '/view';
                    $nameOrderLink .= "?";
                    $ageOrderLink = $_SERVER['HTTP_HOST'] . '/view';
                    $ageOrderLink .= "?";
                    $emailOrderLink = $_SERVER['HTTP_HOST'] . '/view';
                    $emailOrderLink .= "?";
                    $phoneOrderLink = $_SERVER['HTTP_HOST'] . '/view';
                    $phoneOrderLink .= "?";
                    $genderOrderLink = $_SERVER['HTTP_HOST'] . '/view';
                    $genderOrderLink .= "?";
                    foreach ($filters as $field => $filter) {
                        $nameOrderLink .= "filter[" . $field . "]=" . $filter . "&";
                        $ageOrderLink .= "filter[" . $field . "]=" . $filter . "&";
                        $emailOrderLink .= "filter[" . $field . "]=" . $filter . "&";
                        $phoneOrderLink .= "filter[" . $field . "]=" . $filter . "&";
                        $genderOrderLink .= "filter[" . $field . "]=" . $filter . "&";
                    }
                    $nameOrderLink .= "order[name]=name&order[type]=asc";
                    $ageOrderLink .= "order[name]=age&order[type]=asc";
                    $emailOrderLink .= "order[name]=email&order[type]=asc";
                    $phoneOrderLink .= "order[name]=phone&order[type]=asc";
                    $genderOrderLink .= "order[name]=gender&order[type]=asc";
                } else {
                    $nameOrderLink = $_SERVER['HTTP_HOST'] . '/view' . "?order[name]=name&order[type]=asc";
                    $ageOrderLink = $_SERVER['HTTP_HOST'] . '/view' . "?order[name]=age&order[type]=asc";
                    $emailOrderLink = $_SERVER['HTTP_HOST'] . '/view' . "?order[name]=email&order[type]=asc";
                    $phoneOrderLink = $_SERVER['HTTP_HOST'] . '/view' . "?order[name]=phone&order[type]=asc";
                    $genderOrderLink = $_SERVER['HTTP_HOST'] . '/view' . "?order[name]=gender&order[type]=asc";
                }
            }
        } else {
            if (count($_GET) > 1) {
                $nameOrderLink = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "&order[name]=name&order[type]=asc";
                $ageOrderLink = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "&order[name]=age&order[type]=asc";
                $emailOrderLink = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "&order[name]=email&order[type]=asc";
                $phoneOrderLink = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "&order[name]=phone&order[type]=asc";
                $genderOrderLink = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "&order[name]=gender&order[type]=asc";
            } else {
                $nameOrderLink = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?order[name]=name&order[type]=asc";
                $ageOrderLink = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?order[name]=age&order[type]=asc";
                $emailOrderLink = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?order[name]=email&order[type]=asc";
                $phoneOrderLink = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?order[name]=phone&order[type]=asc";
                $genderOrderLink = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?order[name]=gender&order[type]=asc";
            }
        }
        $params = [];
        foreach ($filters as $field => $value) {
            if ($value != '' && $field != 'order' && $field != 'valOrder') {
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
        $orders = [];
        if (isset($_GET['order'])) {
            $orders = [$_GET['order']['name'] => $_GET['order']['type']];
        }
        $users = User::where($params)::orderBy($orders)::get();
        return View::render('view', [
            'users' => $users,
            'name' => $nameOrderLink,
            'age' => $ageOrderLink,
            'email' => $emailOrderLink,
            'phone' => $phoneOrderLink,
            'gender' => $genderOrderLink
        ]);
    }
}