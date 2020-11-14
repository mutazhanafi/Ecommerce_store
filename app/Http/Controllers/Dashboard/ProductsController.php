<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategoryType;
use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Requests\ProductPriceValidation;
use App\Http\Requests\ProductStockRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use DB;

class ProductsController extends Controller
{

    public function index()
    {
        $products = Product::select('id', 'slug', 'is_active', 'price', 'created_at')->paginate(PAGINATION_COUNT);
        return view('dashboard.products.general.index', compact('products'));
    }

    public function create()
    {
        $data = [];
        $data['brands'] = Brand::active()->select('id')->get();
        $data['tags'] = Tag::select('id')->get();
        $data['categories'] = Category::active()->select('id')->get();


        return view('dashboard.products.general.create', $data);
    }

    public function store(GeneralProductRequest $request)
    {


        DB::beginTransaction();

        //validation

        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);

        $product = Product::create([
            'slug' => $request->slug,
            'brand_id' => $request->brand_id,
            'is_active' => $request->is_active,
        ]);
        //save translations
        $product->name = $request->name;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->save();

        //save product categories

        $product->categories()->attach($request->categories);

        //save product tags

        DB::commit();
        return redirect()->route('admin.products')->with(['success' => __('admin/maincatogries.message_success_add')]);


    }


    public function getPrice($product_id)
    {
        $price = Product::orderBy('id', 'DESC')->find($product_id);

        return view('dashboard.products.prices.create', compact('price'))->with('id', $product_id);
    }

    public function saveProductPrice(ProductPriceValidation $request)
    {

        try {

            Product::whereId($request->product_id)->update($request->only(['price', 'special_price', 'special_price_type', 'special_price_start', 'special_price_end']));

            return redirect()->route('admin.products')->with(['success' => __('admin/maincatogries.message_success')]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.products')->with(['error' => __('admin/maincatogries.message_error')]);

        }
    }


    public function getStock($product_id)
    {
        $price = Product::orderBy('id', 'DESC')->find($product_id);

        return view('dashboard.products.stock.create', compact('price'))->with('id', $product_id);
    }

    public function savestock(ProductStockRequest $request)
    {


        Product::whereId($request->product_id)->update($request->only(['sku', 'manage_stock', 'in_stock', 'qty']));

        return redirect()->route('admin.products')->with(['success' => __('admin/maincatogries.message_success')]);

    }

    public function delete_image()
    {
        if (request()->has('id')) {
            $product = ProductImage::findOrfail(request('id'));
            if (File::exists($product->photo)) {
                File::delete($product->photo);
            }
            $product->delete();
        }
    }

    public function addImages($product_id)
    {
        $data = Image::find($product_id);





        return view('dashboard.products.images.create', compact('data'))->with('id', $product_id);
    }


    //to save images to folder only
    public function saveProductImages(Request $request ){

        $file = $request->file('dzfile');
        $filename = uploadImage('products', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);

    }

    public function saveProductImagesDB(ProductImagesRequest $request){

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

        }catch(\Exception $ex){
            return redirect()->route('admin.products')->with(['error' => __('admin/maincatogries.message_error')]);

        }

    }
    public function edit($id)
    {

        $product = Product::find($id);
        $data = [];
        $data['brands'] = Brand::active()->select('id')->get();
        $data['tags'] = Tag::select('id')->get();
        $data['categories'] = Category::active()->select('id')->get();
        if (!$product)
            return redirect()->route('admin.products')->with(['error' => __('admin/maincatogries.message_error-not found')]);

        return view('dashboard.products.general.edit', $data , compact('product'));

    }


    public function update($id, GeneralProductRequest $request)
    {
        try {
            //validation

            //update DB


            $product = Product::find($id);

            if (!$product)
                return redirect()->route('admin.products')->with(['error' => __('admin/maincatogries.message_error-not found')]);


            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $product->update($request->all());

            //save translations
            $product->name = $request->name;
            $product->save();
            return redirect()->route('admin.products')->with(['success' => __('admin/maincatogries.message_success')]);

        } catch (\Exception $ex) {
            return redirect()->route('admin.products')->with(['error' => __('admin/maincatogries.message_error')]);

        }

    }


    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $product = Product::orderBy('id', 'DESC')->find($id);

            if (!$product)
                return redirect()->route('admin.products')->with(['error' => 'هذا القسم غير موجود ']);
            $product -> translations() ->delete(); ///حذف الترمات من كل الجداول/////

            $product->delete();

            return redirect()->route('admin.products')->with(['success' => 'تم  الحذف بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.products')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

}
