<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoriesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {

        $categories = Category::all();
        return view('categories.index')->with([
            'categories' => $categories
        ]);

    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->merge(['status'=>'active']);
        $category = Category::create($request->all());
        Session::flash('success','Category has been added');
        return redirect('/category');
    }

    public function show($id)
    {
        return redirect('/category/'.$id.'/edit');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit')->with([
            'category'=>$category
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if($category!=null){
            $category->fill($request->all())->save();
            Session::flash('success', 'Category has been updated successfully');
        }else{
            Session::flash('error','Category was not found.');
        }
        return redirect()->back();


    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return 1;
    }

}
