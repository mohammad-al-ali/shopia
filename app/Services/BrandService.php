<?php

namespace App\Services;

use App\Models\Brand;
use App\Repositories\BrandRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits;
use Illuminate\Validation\ValidationException;


class BrandService
{ use Traits\ProcessImageTrait;
    protected BrandRepository $brandRepository;
    protected string $brandFolder='brands_image';
    private $productRepository;

    public function __construct(BrandRepository $brandRepository){
        $this->brandRepository=$brandRepository;
    }
    private function prepareBrandData($request){
        $data=$request->only([
            'name','description'
        ]);
        $data['slug']=Str::slug($request->name);
        return $data;
    }
    public function handleStoreBrand($request): void
    {
        $data=$this->prepareBrandData($request);
        $data['image']=$this->processImage($request->file('image'),124,124,$this->brandFolder);
        $this->brandRepository->create($data);
    }
    public function handleUpdateBrand($request): void
    {
        $brand=$this->brandRepository->findById($request->id);
        $data=$this->prepareBrandData($request);
        if ($request->image){
            $data['image']=$this->replaceImage($brand->image,$request->file('image'),124,124,$this->brandFolder);
        }
        $this->brandRepository->update($brand,$data);

    }

    /**
     * @throws Exception
     */
    public function handleDeleteBrand($id): void
    {
        DB::beginTransaction();

        try {
            $brand = Brand::findOrFail($id);

            // حذف الصورة الرئيسية
            $this->deleteImage($brand->image,$this->brandFolder);

                $this->brandRepository->delete($brand);


            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            throw $e; // أو يمكنك التعامل مع الخطأ بطريقة أخرى حسب الحاجة
        }

    }


}
