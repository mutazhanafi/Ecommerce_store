<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use DB;

class MainCategoriesController extends Controller
{

    public function index()
    {
        $categories = Category::with('_parent')->orderBy('id','DESC') -> paginate(PAGINATION_COUNT);
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories =   Category::select('id','parent_id')->get();

        return view('dashboard.categories.create',compact('categories'));
    }


    public function store(MainCategoryRequest $request)
    {

        try {

            DB::beginTransaction();

            //validation

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            //if user choose main category then we must remove paret id from the request

            if($request -> type == 1) //main category
            {
                $request->request->add(['parent_id' => null]);
            }

            //if he choose child category we mus t add parent id


            $category = Category::create($request->except('_token'));

            //save translations
            $category->name = $request->name;
            $category->save();
 DB::commit();
            return redirect()->route('admin.maincategories')->with(['success' => __('admin/maincatogries.message_success_add')]);

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.maincategories')->with(['error' => __('admin/maincatogries.message_error')]);
        }

    }


    public function edit($id)
    {

        //get specific categories and its translations
        $category = Category::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect()->route('admin.maincategories')->with(['error' => __('admin/maincatogries.message_error-not found')]);

        return view('dashboard.categories.edit', compact('category'));

    }


    public function update($id, MainCategoryRequest $request)
    {
        try {
            //validation

            //update DB


            $category = Category::find($id);

            if (!$category)
                return redirect()->route('admin.maincategories')->with(['error' => __('admin/maincatogries.message_error-not found')]);

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category->update($request->all());

            //save translations
            $category->name = $request->name;
            $category->save();

            return redirect()->route('admin.maincategories')->with(['success' => __('admin/maincatogries.message_success')]);
        } catch (\Exception $ex) {

            return redirect()->route('admin.maincategories')->with(['error' => __('admin/maincatogries.message_error')]);
        }

    }


    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $category = Category::orderBy('id', 'DESC')->find($id);

            if (!$category)
                return redirect()->route('admin.maincategories')->with(['error' => __('admin/maincatogries.message_error-not found')]);

            $category->delete();

            return redirect()->route('admin.maincategories')->with(['success' => __('admin/maincatogries.message_delete')]);

        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => __('admin/maincatogries.message_error')]);
        }
    }

}
