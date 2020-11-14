<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategoryType;
use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\OptionsRequest;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Requests\ProductPriceValidation;
use App\Http\Requests\ProductStockRequest;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Option;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use DB;

class OptionsController extends Controller
{

    public function index()
    {
         $options = Option::with(['product' => function ($prod) {
            $prod->select('id');
        }, 'attribute' => function ($attr) {
            $attr->select('id');
        }])->select('id', 'product_id', 'attribute_id', 'price')->paginate(PAGINATION_COUNT);

      return   view('dashboard.options.index', compact('options'));
    }

    public function create()
    {
        $data = [];
        $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();

        return view('dashboard.options.create', $data);
    }

    public function store(OptionsRequest $request)
    {


        DB::beginTransaction();

        //validation
        $option = Option::create([
            'attribute_id' => $request->attribute_id,
            'product_id' => $request->product_id,
            'price' => $request->price,
        ]);
        //save translations
        $option->name = $request->name;
        $option->save();
        DB::commit();

        return redirect()->route('admin.options')->with(['success' => __('admin/maincatogries.message_success_add')]);
    }


    public function getPrice($product_id)
    {

        return view('dashboard.products.prices.create')->with('id', $product_id);
    }

    public function saveProductPrice(ProductPriceValidation $request)
    {

        try {

            Product::whereId($request->product_id)->update($request->only(['price', 'special_price', 'special_price_type', 'special_price_start', 'special_price_end']));

            return redirect()->route('admin.products')->with(['success' => __('admin/maincatogries.message_success')]);
        } catch (\Exception $ex) {

        }
    }


    public function getStock($product_id)
    {

        return view('dashboard.products.stock.create')->with('id', $product_id);
    }

    public function saveProductStock(ProductStockRequest $request)
    {


        Product::whereId($request->product_id)->update($request->except(['_token', 'product_id']));

        return redirect()->route('admin.products')->with(['success' => __('admin/maincatogries.message_success')]);

    }

    public function addImages($product_id)
    {
        return view('dashboard.products.images.create')->withId($product_id);
    }

    //to save images to folder only
    public function saveProductImages(Request $request)
    {

        $file = $request->file('dzfile');
        $filename = uploadImage('products', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);

    }

    public function saveProductImagesDB(ProductImagesRequest $request)
    {

        try {
            // save dropzone images
            if ($request->has('document') && count($request->document) > 0) {
                foreach ($request->document as $image) {
                    Image::create([
                        'product_id' => $request->product_id,
                        'photo' => $image,
                    ]);
                }
            }

            return redirect()->route('admin.products')->with(['success' => __('admin/maincatogries.message_success')]);

        } catch (\Exception $ex) {

        }
    }

    public function edit($id)
    {
         $options = Option::orderBy('id', 'DESC')->find($id);
        $data = [];
        $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();
        //get specific categories and its translations
       

        if (!$options)
            return redirect()->route('admin.options')->with(['error' => __('admin/maincatogries.message_error-not found')]);

        return view('dashboard.options.edit', $data, compact('options'));

    }


    public function update($id, OptionsRequest $request)
    {
        try {
            //validation

            //update DB


            $options = Option::find($id);

            if (!$options)
                return redirect()->route('admin.options')->with(['error' => __('admin/maincatogries.message_error-not found')]);

           

            $options->update($request->all());

            //save translations
            $options->name = $request->name;
            $options->save();

            return redirect()->route('admin.options')->with(['success' => __('admin/maincatogries.message_success')]);
        } catch (\Exception $ex) {

            return redirect()->route('admin.options')->with(['error' => __('admin/maincatogries.message_error')]);
        }

    }


    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $options = Option::orderBy('id', 'DESC')->find($id);

            if (!$options)
                return redirect()->route('admin.options')->with(['error' => __('admin/maincatogries.message_error-not found')]);
            $options -> translations() ->delete(); ///حذف الترمات من كل الجداول/////

            $options->delete();

            return redirect()->route('admin.options')->with(['success' => __('admin/maincatogries.message_delete')]);

        } catch (\Exception $ex) {
            return redirect()->route('admin.options')->with(['error' => __('admin/maincatogries.message_error')]);
        }
    }

}
