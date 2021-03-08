<?php

namespace App\Http\Controllers;

use App\Prefix;
use App\Profession;
use Illuminate\Http\Request;

class PortalApiController extends Controller
{
    //

    public function sign_up(){
        $professions = Profession::with('prefix')->get();
        return response()->json([
            'professions' => $professions,
        ]);
    }

    public function profession_prefixes(Prefix $prefix){
        return response()->json([
            'prefix' => collect($prefix),
        ]);
    }
}
