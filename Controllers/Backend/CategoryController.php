<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\SlugGenerator;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    use SlugGenerator;

    public function category(){

       $categorys = Category::with('subcategories')->latest()->paginate(30);



       $parentCategories = $categorys->where('category_id', null)->flatten();
 dd($parentCategories);

       return view('backend.category.index', compact('categorys', 'parentCategories'));
     }



   // StoRe data.
       public function categoryInsert(Request $request){


       $slug = $this->createSlug(Category::class, $request->category);
       $categoryStore = new Category();
        $categoryStore->category = $request->category;
        $categoryStore->category_id = $request->category_id;
        $categoryStore->category_slug = $slug;
        $categoryStore->save();
        return back();
        }


        // edit
        public function categoryEdit($id){
            $categorys = Category::latest()->paginate(2);
            $findCategory = Category::find($id);
            // dd($categorys);
            return view('backend.category.index', compact('categorys','findCategory'));
            // return view('backend.category.index', compact('categorys', 'findCategory'));
        }



        // update
        public function categoryUpdate(Request $request, $id){
             $updateCategory = Category::find($id);
             $updateCategory->category = $request->category;
             $updateCategory->category_slug = Str::slug($request->category);
             $updateCategory->save(); return back();
           //  dd($updateCategory);
        }

        // delete
        public function categoryDelete($id){
           Category::find($id)->delete( );
           return back();
        }
     }
