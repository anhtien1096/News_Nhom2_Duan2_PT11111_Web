<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Posts;

class HomeController extends Controller
{

    public function index()
    {
        $posts = Posts::orderBy('created_at', 'DESC')
                    ->limit(10)
                    ->get();
        return view('home',compact('posts'));
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $posts   = Posts::orderBy('created_at', 'DESC')
                    ->where('title','like',"%$keyword%")
                    ->orwhere('description','like',"%$keyword%")
                    ->orwhere('content','like',"%$keyword%")
                    ->get();
        return view('widgets.search',compact('posts','keyword'));
    }

    public function getProfile(){
        return view('user.profile');
    }

}