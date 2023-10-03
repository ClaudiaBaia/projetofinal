<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryFormRequest;

class CategoryController extends Controller
{
   public function index()
   {
        return view('admin.category.index');
   }

   public function create()
   {
        return view('admin.category.create');
   }
   
   public function store(CategoryFormRequest $request)
   {
        //validation 
        $validatedData = $request->validated();

        $category = new Category;
        $category->name = $validatedData['name'];
        $category->slug = Str::slug($validatedData['slug']);
       
        $category->description = $validatedData['description'];

        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;

            $file->move('uploads/category/',$filename);
            $category->image = $filename;
        }

       


        $category->meta_title = $validatedData['meta_title'];
        $category->meta_keyword = $validatedData['meta_keyword'];
        $category->meta_description = $validatedData['meta_description'];

        $category->status = $request->status == true ? '1':'0';
        $category->save();

        return redirect('admin/category')->with('message', 'Categoria adicionada com sucesso');
   }
}
