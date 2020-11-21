<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controler;
use App\Models\Comment;
use App\Models\APIError;


class CommentController extends Controller
{
    public function index(Request $request)
    {
        $data=Comment::simplePaginate($request->has('limit') ? $request->limit : 25);
        return response()-> json($data);
    }

    public function create (Request $request)
    {
        $this->validate($request->all() , [
            'name'=>'required'
        ]);
        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'email',
            'website',
            'content'
            ]));
        $comment = Comment::create($data);    
         
        return response()-> json($comment);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        if (!$comment) 
        {
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("comment not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
            return response()-> json($error , 404);
            

        }
           $data = [];
           $data = array_merge($data, $request->only([
            'name',
            'email',
            'website',
            'content'
            ]));
            $comment->name = $data['name'];
            $comment->email = $data['email'];
            $comment->website = $data['website'];
            $comment->content = $data['content'];
            $comment->update();
            return response()->json($comment);


    }

   public function find($id)
   {
     $comment = Comment::find($id);
    if (!$comment) 
    {
        $error = new APIError;
        $error-> setStatus("404");
        $error-> setCode("comment not found");
        $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
        return response()-> json($error , 404);

    } 
    return response()->json($comment);

   }

    public function delete($id)
    {
        $comment = Comment::find($id);
        if (!$comment) 
        {
        $error = new APIError;
        $error-> setStatus("404");
        $error-> setCode("comment not found");
        $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
        return response()-> json($error , 404);
        }
     
        $comment -> delete($id);
        return response()->json();
    }



}   