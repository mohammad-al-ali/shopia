<?php
namespace App\Services;

use App\Repositories\ProductRepository;
use App\Traits\ProcessImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Throwable;


class ProductService
{
    use ProcessImageTrait;

    protected ProductRepository $productRepository;
    protected string $productFolder='products_image';
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    private function prepareProductData(Request $request): array
    {
        $data = $request->only([
            'name', 'description', 'short_description', 'regular_price',
            'sale_price', 'warehouse_price', 'featured', 'quantity',
            'brand_id', 'category_id'
        ]);
        $data['slug']=Str::slug($request->name);
        return $data;
    }

    private function handleGallery($files): ?string
    { if (!$files) return null;
        $galleryArray = [];
        $count = 1;
        foreach ($files as $file) {
            $fileName =  $this->processImage($file, 540, 689, $this->productFolder.'/gallery', $count);
            $galleryArray[] = $fileName;
            $count++;
        }
        return  implode(',', $galleryArray);
    }

    private function deleteGallery($gallery,$folderName): void
    {
        if (!$gallery) return;
        foreach (explode(',',$gallery) as $image){
            $this->deleteImage($image,$folderName.'/gallery');
        }


    }

    public function handleStoreProduct(Request $request): void
    {
        // 🧺 3. تجهيز البيانات للحفظ
        $data = $this->prepareProductData($request);
        // 🖼️ 1. معالجة الصورة الرئيسية
            $data['image']= $this->processImage($request->file('image'), 540, 689, $this->productFolder);
        // 🖼️ 2. معالجة صور المعرض
            $data['images'] =$this->handleGallery($request->file('images'));
        // 💾 4. حفظ المنتج عبر الريبو
        $this->productRepository->create($data);
    }
    public function handleUpdateProduct(Request $request, $id): void
    {
        $data=$this->prepareProductData($request);
        $product = $this->productRepository->find($id);
        // ✅ معالجة الصورة الرئيسية
        if ($request->image){
            $data['image']=$this->replaceImage($product->image,$request->file('image'),540,689,$this->productFolder);
        }
        // ✅ معالجة معرض الصور
        if ($request->file('images')){
            $data['images'] = $this->handleGallery($request->file('images'));
            $this->deleteGallery($product->images,$this->productFolder);
        }


        // ✅ التحديث النهائي
        $this->productRepository->update($product,$data);
    }

    public function handleDeleteProduct($id): void
    {
        DB::beginTransaction();

        try {
            $product = $this->productRepository->find($id);

            $this->deleteImage($product->image,$this->productFolder);
            $this->deleteGallery($product->images,$this->productFolder);

            $product->forceDelete();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            // soft delete
            if (isset($product)) {
                $this->productRepository->update($product,['deleted_at'=>now()]);
            }

            // اختياري: سجل الخطأ للتصحيح لاحقًا
            // Log::error($e->getMessage());
        }
    }



}
