<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Posts;
use App\Comments;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function index()
    {
        $posts = Posts::orderBy('created_at', 'DESC')
                    ->where('status', 1)
                    ->paginate(20);
        return view('posts.index',compact('posts','categories'));
    }

    public function getPost($param)
    {
        $posts = Posts::where('slug', $param)
                    ->where('status', 1)
                    ->firstOrFail();
        $comments = $posts->comments()->where([
            ['status', 1],
        ])->get();
        return view('posts.getpost',compact('posts'))
            ->with([
                'comments'  => $comments,
            ]);
    }

    public function ajax(Request $request)
    {
        return $this->{$request->type}($request);
    }

    private function addComment($request)
    {
        $comments = Comments::create([
            'content'   => $request->content,
            'parent_id' => $request->parent,
            'user_id'   => Auth::user()->id,
            'post_id'   => $request->id,
            'status'    => 0,
        ]);

        return response()->json([
            'comments'  => $comments,
        ]);
    }

    private function update_view($request)
    {
        $post = Posts::find($request->id);

        $view = $post->view;

        if (empty($view)) {
            $post->addMeta('view', 1);
            return;
        }
        $view++;
        $post->updateMeta('view', $view);
        return;
    }

}
