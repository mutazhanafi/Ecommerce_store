<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\TagsRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use DB;

class TagsController extends Controller
{

    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('dashboard.tags.create');
    }


    public function store(TagsRequest $request)
    {


        DB::beginTransaction();

        //validation
        $tag = Tag::create(['slug' => $request -> slug]);

        //save translations
        $tag->name = $request->name;
        $tag->save();
        DB::commit();
        return redirect()->route('admin.tags')->with(['success' => __('admin/tags.message_success_add')]);


    }


    public function edit($id)
    {

        //get specific categories and its translations
        $tag = Tag::find($id);

        if (!$tag)
            return redirect()->route('admin.tags')->with(['error' => __('admin/tags.message_error-not found')]);

        return view('dashboard.tags.edit', compact('tag'));

    }


    public function update($id, TagsRequest  $request)
    {
        try {
            //validation

            //update DB

        $id = $request->id;

            $tag = Tag::find($id);

            if (!$tag)
                return redirect()->route('admin.tags')->with(['error' => __('admin/tags.message_error-not found')]);


            DB::beginTransaction();


            $tag->update($request->except('_token', 'id'));  // update only for slug column

            //save translations
            $tag->name = $request->name;
            $tag->save();

            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => __('admin/tags.message_success')]);

        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->route('admin.tags')->with(['error' => __('admin/tags.message_error')]);
        }

    }


    public function destroy($id )
    {
     
            //get specific categories and its translations

            $tags = Tag::find($id);

            if (!$tags)
                return redirect()->route('admin.tags')->with(['error' => __('admin/tags.message_error-not found')]);
            $tags -> translations() ->delete(); ///حذف الترمات من كل الجداول/////
            $tags->delete();

            return redirect()->route('admin.tags')->with(['success' => __('admin/tags.message_delete')]);
}

}
