<?php
namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    //COUPON FUNCTION
    public function coupons(){
        $coupons=Coupon::orderBy('expiry_date','DESC')->paginate(12);
        return view('admin.coupon.coupons',compact('coupons'));
    }
    public function createCoupon(){
        return view('admin.coupon.create');
    }
    public function storeCoupon(Request $request)
    {
// ✅ 1. التحقق من صحة المدخلات
        $request->validate([
            'code'=>'required',
            'type'=>'required',
            'value'=>'required|numeric',
            'cart_value'=>'required|numeric',
            'expiry_date'=>'required|date',
        ]);

// ✅ 2. معالجة الصورة (إذا تم رفعها)

        Coupon::create([
            'code'=>$request->code,
            'type'=>$request->type,
            'value'=>$request->value,
            'cart_value'=>$request->cart_value,
            'expiry_date'=>$request->expiry_date,
        ]);

// ✅ 4. إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.coupon.coupons')->with('status', 'تمت إضافة الكوبون!');
    }
    public function editCoupon($id){
        $coupon=Coupon::find($id);
        return view('admin.coupon.edit',compact('coupon'));
    }
    public function updateCoupon(Request $request)
    {
// ✅ 1. التحقق من صحة المدخلات

        $request->validate([
            'code'=>['required','unique:coupons,code,' .$request->id],
            'type'=>['required'],
            'value'=>['required','numeric'],
            'cart_value'=>['required','numeric'],
            'expiry_date'=>['required','date'],
        ]);
        $coupon=Coupon::find($request->id);

        $coupon->update([
            'code'=>$request->code,
            'type'=>$request->type,
            'value'=>$request->value,
            'cart_value'=>$request->cart_value,
            'expiry_date'=>$request->expiry_date,
            'updated_at'=>now(),
        ]);

// ✅ 4. إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.coupon.coupons')->with('status', 'تمت تعديل الكوبون!');
    }
    public function deleteCoupon($id){
        Coupon::find($id)->delete();
        return redirect()->route('admin.coupon.coupons')->with('status', 'تمت حذف الكوبون!');

    }
    //BRAND`S FUNCTION
    public function index()
    {

        return view('admin.index');
    }
    public function brands(){
        $brands=Brand::orderBy('id','DESC')->paginate(10);
        return view('admin.brand.brands',compact('brands'));
    }
    public function createBrand(){
        return view('admin.brand.create');
    }
    public function storeBrand(Request $request)
{
// ✅ 1. التحقق من صحة المدخلات
    $request->validate([
        'name'        => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:1000'],
        'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2028'],
    ]);


// ✅ 2. معالجة الصورة (إذا تم رفعها)
$file_name = null;
if ($request->hasFile('image')) {
$image = $request->file('image');
$file_name = time() . '.' . $image->extension();

// معالجة الصورة
$this->processImage($image, $file_name,124,124,'brands_image');
}

// ✅ 3. حفظ العلامة التجارية داخل قاعدة البيانات
    $brand = Brand::create([
        'name'        => $request->name,
        'slug'        => Str::slug($request->name),
        'description' => $request->description,
        'image'       => $file_name,
    ]);

// ✅ 4. إعادة التوجيه مع رسالة نجاح
return redirect()->route('admin.brand.brands')->with('status', 'تمت إضافة العلامة التجارية بنجاح!');
}
    public function editBrand($id){
        $brand=Brand::find($id);
        return view('admin.brand.edit',compact('brand'));
    }
    public function updateBrand(Request $request)
    {  $brand = Brand::find($request->id);
// ✅ 1. التحقق من صحة المدخلات
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => [ 'string', 'max:255','unique:brands,slug,' .$request->id],
            'description' => ['nullable', 'string', 'max:1000'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2028'],
        ]);


// ✅ 2. معالجة الصورة (إذا تم رفعها)

        if ($request->hasFile('image')) {
//            if(File::exists(storage_path('app/public/brands_image').'/'.$brand->image)){
//                File::delete(storage_path('app/public/brands_image').'/'.$brand->image);
//            }

            $file_name = time() . '.' . $request->file('image')->extension();

// معالجة الصورة
            $this->processImage($request->file('image'), $file_name,124,124,'brands_image');
            $brand->update([
                'image'=>$file_name,
            ]);

        }


// ✅ 3. حفظ العلامة التجارية داخل قاعدة البيانات

        $brand->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'updated_at'=>now(),
        ]);


// ✅ 4. إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.brand.brands')->with('status', 'تمت تعديل العلامة التجارية بنجاح!');
    }
    public function deleteBrand($id){
       $brand= Brand::find($id);
        if (Storage::disk('public')->exists('brands_image/'.$brand->image)) {
            Storage::disk('public')->delete('brands_image/'.$brand->image);
        }
             $brand->delete();
        return redirect()->route('admin.brand.brands')->with('status', 'تمت حذف العلامة التجارية بنجاح!');

    }
    //CATEGORY`S FUNCTION
    public function categories(){
        $categories=Category::orderBy('id','DESC')->paginate(10);
        return view('admin.category.Categories',compact('categories'));
    }
    public function createCategory(){
        return view('admin.category.create');
    }
    public function storeCategory(Request $request)
    {
// ✅ 1. التحقق من صحة المدخلات
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'parent_category_id'=>['nullable' ,'exists:categories,id'],
        ]);
Category::create([
            'name'        => $request->name,
            'description' => $request->description,
            'parent_category_id'       => $request->parent_category_id,
        ]);

// ✅ 4. إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.category.categories')->with('status', 'تمت إضافة الفئة بنجاح!');
    }
    public function editCategory($id){
        $category=Category::find($id);
        return view('admin.category.edit',compact('category'));
    }
    public function updateCategory(Request $request)
    {  $category =Category::find($request->id);
// ✅ 1. التحقق من صحة المدخلات
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'parent_category_id'=>['nullable' ,'exists:categories,id'],
        ]);


// ✅ 2. معالجة الصورة (إذا تم رفعها)

// ✅ 3. حفظ العلامة التجارية داخل قاعدة البيانات
        $category = Category::find($request->id);
        $category->update([
            'name'        => $request->name,
            'description' => $request->description,
            'parent_category_id'=>$request->parent_category_id,
            'updated_at'=>now()
        ]);

        return redirect()->route('admin.category.categories')->with('status', 'تمت تعديل الفئة بنجاح!');
    }
    public function deleteCategory($id){
        $category=Category::find($id)->delete();
        return redirect()->route('admin.category.categories')->with('status', 'تمت حذف الفئة بنجاح!');

    }
    //PRODUCT`S FUNCTION
    public function products(){
        $products=Product::orderBy('id','DESC')->paginate(10);
        return view('admin.product.products',compact('products'));
    }
    public function createProduct(){
        $categories=Category::select('id','name')->orderBy('name')->get();
        $brands=Brand::select('id','name')->orderBy('name')->get();

        return view('admin.product.create',compact('categories','brands'));
    }
    public function storeProduct(Request $request)
    {
// ✅ 1. التحقق من صحة المدخلات
        $request->validate([
            'name'            =>                      ['required', 'string', 'max:255'],
            'description'     =>                                 ['nullable', 'string'],
            'short_description'                       =>         ['nullable', 'string'],
            'regular_price' =>                         ['required', 'numeric', 'min:0'],
            'sale_price' =>                             ['nullable','numeric', 'min:0'],
            'warehouse_price' =>                        ['required','numeric', 'min:0'],
            'featured'    =>                                    ['nullable', 'boolean'],
            'quantity'        =>                       ['required', 'integer', 'min:0'],
            'image'           =>['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'images' =>                                           [ 'nullable','array'],
            'images.*' =>       ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'brand_id'        =>                       ['nullable', 'exists:brands,id'],
            'category_id'     =>                   ['nullable', 'exists:categories,id'],
        ]);
        if($request->regular_price<$request->warehouse_price){
            return back()->with('status','invalid price');
        }

// ✅ 2. معالجة الصورة (إذا تم رفعها)
        $image_name = null;

        if ($request->hasFile('image')) {
            $image_name = time() . '.' . $request->file('image')->extension();

// معالجة الصورة
            $this->processImage($request->file('image'), $image_name,540,689,'products_image');
        }
//        $gallery=""; // ✅ تخزين أسماء الصور
        $gallery_array=[];
        if ($request->hasFile('images')) {
            $count=1;
            foreach ($request->file('images') as $file) {


                $file_name =time().'-'. $count . '.' . $file->extension();
                $this->processImage($file, $file_name,540,689,'products_image/gallery');// ✅ حفظ الصورة
                $gallery_array[] = $file_name; // ✅ إضافة اسم الصورة للمصفوفة

                $count++;


            }

        }

      Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'slug'        => Str::slug($request->name),
            'quantity'       => $request->quantity,
            'regular_price'=>$request->regular_price,
            'sale_price'=>$request->sale_price,
            'warehouse_price'=>$request->warehouse_price,
            'image'=>$image_name,
            'images' => implode(',',$gallery_array), // ✅ تحويل المصفوفة إلى نص مفصول بفاصلة
            'featured'=>$request->featured,
            'brand_id'=>$request->brand_id,
            'category_id'=>$request->category_id,

        ]);

// ✅ 4. إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.product.products')->with('status', 'تمت إضافة المنتج بنجاح!');
    }
    public function editProduct($id){
        $product=Product::find($id);
        $categories=Category::select('id','name')->orderBy('name')->get();
        $brands=Brand::select('id','name')->orderBy('name')->get();
return view('admin.product.edit',compact('product','categories','brands'));
    }
    public function updateProduct(Request $request,$id)
    {  $product=Product::find($id);

// ✅ 1. التحقق من صحة المدخلات
        $request->validate([
            'name'            =>                      ['required', 'string', 'max:255'],
            'slug'        =>        [ 'string', 'max:255','unique:products,slug,' .$id],
            'description'     =>                                 ['nullable', 'string'],
            'short_description'                       =>         ['nullable', 'string'],
            'regular_price' =>                         ['required', 'numeric', 'min:0'],
            'sale_price' =>                             ['nullable','numeric', 'min:0'],
            'warehouse_price' =>                        ['required','numeric', 'min:0'],
            'featured'    =>                                    ['nullable', 'boolean'],
            'quantity'        =>                       ['required', 'integer', 'min:0'],
            'image'           =>['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'images' =>                                           [ 'nullable','array'],
            'images.*' =>       ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'brand_id'        =>                       ['nullable', 'exists:brands,id'],
            'category_id'     =>                   ['nullable', 'exists:categories,id'],
        ]);
        if($request->regular_price<$request->warehouse_price){
            return back()->with('status','invalid price');
        }


// ✅ 2. معالجة الصورة (إذا تم رفعها)

        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists('products_image/'.$product->image)) {
                Storage::disk('public')->delete('products_image/'.$product->image);
            }

            $file_name = time() . '.' . $request->file('image')->extension();

// معالجة الصورة
            $this->processImage($request->file('image'), $file_name,540,689,'products_image');
            $product->update([
                'image'=>$file_name,
            ]);
        }
        $new_gallery_array=[];
        if ($request->hasFile('images')) {

            $count=1;
            foreach (explode(',',$product->images) as $image){
                    Storage::disk('public')->delete('products_image/gallery/'.$image);

            }
            foreach ($request->images as $file) {


                $file_name =time().'-'. $count . '.' . $file->extension();
                $this->processImage($file, $file_name,540,689,'products_image/gallery');// ✅ حفظ الصورة
                $new_gallery_array[] = $file_name;                                                 // ✅ إضافة اسم الصورة للمصفوفة

                $count++;


            }
            $product->update([
                'images' => implode(',',$new_gallery_array)           , // ✅ تحويل المصفوفة إلى نص مفصول بفاصلة

            ]);

        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'slug'        => Str::slug($request->name),
            'quantity'       => $request->quantity,
            'regular_price'=>$request->regular_price,
            'sale_price'=>$request->sale_price,
            'warehouse_price'=>$request->warehouse_price,
            'featured'=>$request->featured,
            'brand_id'=>$request->brand_id,
            'category_id'=>$request->category_id,
            'updated_at'=>now(),
        ]);

        return redirect()->route('admin.product.products')->with('status', 'تمت تعديل المنتج بنجاح!');
    }
    public function deleteProduct($id){

            $product = Product::find($id);


                // حذف الصورة الرئيسية
                if (Storage::disk('public')->exists('products_image/'.$product->image)) {
                    Storage::disk('public')->delete('products_image/'.$product->image);
                }

                // حذف الصور من المعرض إذا كانت موجودة
                if ($product->images) {
                    foreach (explode(',', $product->images) as $image) {
                        if (Storage::disk('public')->exists('products_image/gallery/'.$image)) {
                            Storage::disk('public')->delete('products_image/gallery/'.$image);
                        }
                    }
                }

                // حذف المنتج من قاعدة البيانات
                $product->delete();

                return redirect()->route('admin.product.products')->with('status', 'تم حذف المنتج بنجاح!');
            }





    public function processImage($image, $file_name,$width,$height,$folder_name)
    {
// 🔹 تحديد المسار داخل storage
        $destinationPath = storage_path('app/public/'.$folder_name);

// 🔹 قراءة الصورة باستخدام Intervention Image
        $img = Image::read($image->path());// 🔹 حفظ الصورة في storage

        $img->resize($width,$height);
        $img->save($destinationPath.'/'.$file_name);
    }

}
