<?php

namespace App\Http\Controllers;

use App\Models\{
    User,
    Video
};
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $videos = Video::query();

        $name = $request->name;

        if(!empty($name)){
            $videos = $videos->where('title', 'like', '%' . $name . '%');
        }

        $videos = $videos->get();

        return view('welcome', compact('videos', 'name'));
    }


    public function GetUserInfo(User $user){
        return $user;
    }
}
