<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrcidUserController extends Controller
{
    public function home (){
        $res = file_get_contents('http://localhost/metabiblioteca-rest/public/api/orcid/list');
        $items['items'] = json_decode($res, true);
        return view('home', $items);
    }
}
