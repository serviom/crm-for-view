<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    static public function phone_format($number) {
        $result = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '+38 ($1) $2-$3', $number);

        return $result;
    }
}
