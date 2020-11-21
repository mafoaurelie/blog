<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\APIError;


class BlogController extends Controller
{
    public function index(Request $request)
    {
        $data=Blog::simplePaginate($request->has('limit') ? $request->limit : 20);
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
            'description',
            'image'
            ]));
        $blog = Blog::create($data);    
         
        return response()-> json($blog);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        if (!$blog) 
        {
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("blog not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
            return response()-> json($error , 404);
            

        }
           $data = [];
           $data = array_merge($data, $request->only([
            'name',
            'description',
            'image'
            ]));
            $blog->name = $data['name'];
            $blog->description = $data['description'];
            $blog->image = $data['image'];
            $blog->update();
            return response()->json($blog);


    }

   public function find($id)
   {
     $blog = Blog::find($id);
    if (!$blog) 
    {
        $error = new APIError;
        $error-> setStatus("404");
        $error-> setCode("blog not found");
        $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
        return response()-> json($error , 404);
     
    } 
    return response()->json($blog);

   }

   public function delete($id)
   {
    $blog = Blog::find($id);
    if (!$blog) 
    {
        $error = new APIError;
        $error-> setStatus("404");
        $error-> setCode("blog not found");
        $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
        return response()-> json($error , 404);
     
    }
    $blog->delete();
        return response()->json();

   }

}
  

