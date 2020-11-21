<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\APIError;

class BlogCategoryController extends Controller
{
/**
 * \\fonction permettant de lister les elts de la table category
 */
    public function index(Request $request)
    {
        $data=BlogCategory::simplePaginate($request->has('limit') ? $request->limit : 15);
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
            'description'
            ]));
        $blogcategory = BlogCategory::create($data);    
         
        return response()-> json($blogcategory);
    }

    public function update(Request $request, $id)
    {
        $blogcategory = BlogCategory::find($id);
        if (!$blogcategory) 
        {
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("blogcategory not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
            return response()-> json($error , 404);
            

        }
           $data = [];
           $data = array_merge($data, $request->only([
            'name',
            'description'
            ]));
            $blogcategory->name = $data['name'];
            $blogcategory->description = $data['description'];
            $blogcategory->update();
            return response()->json($blogcategory);


    }

   public function find($id)
   {
     $blogcategory = BlogCategory::find($id);
    if (!$blogcategory) 
    {
        $error = new APIError;
        $error-> setStatus("404");
        $error-> setCode("blogcategory not found");
        $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
        return response()-> json($error , 404);
     
    } 
    return response()->json($blogcategory);

   }

   public function delete($id)
   {
    $blogcategory = BlogCategory::find($id);
    if (!$blogcategory) 
    {
        $error = new APIError;
        $error-> setStatus("404");
        $error-> setCode("blogcategory not found");
        $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
        return response()-> json($error , 404);
     
    }
    $blogcategory->delete();
        return response()->json();

   }

}
