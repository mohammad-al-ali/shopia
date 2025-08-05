<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Repositories\BrandRepository;
use App\Services\BrandService;
use Exception;
class BrandController extends Controller
{
    protected BrandRepository $brandRepository;
    protected BrandService $brandService;
    public function __construct(BrandRepository $brandRepository,BrandService $brandService){
        $this->brandRepository=$brandRepository;
        $this->brandService=$brandService;
    }
    public function brands(){
        $brands=$this->brandRepository->getAllPaginated();
        return view('admin.brand.brands',compact('brands'));
    }
    public function create(){
        return view('admin.brand.create');
    }
    public function store(BrandRequest $request)
    { $this->brandService->handleStoreBrand($request);
// ✅ 4. إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.brand.brands')->with('status', 'تمت إضافة العلامة التجارية بنجاح!');
    }
    public function edit($id){
        $brand=$this->brandRepository->findById($id);
        return view('admin.brand.edit',compact('brand'));
    }
    public function update(BrandRequest $request)
    {  $this->brandService->handleUpdateBrand($request);


// ✅ 4. إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.brand.brands')->with('status', 'تمت تعديل العلامة التجارية بنجاح!');
    }

    /**
     * @throws Exception
     */
    public function delete($id){
       $this->brandService->handleDeleteBrand($id);
        return redirect()->route('admin.brand.brands')->with('status', 'تمت حذف العلامة التجارية بنجاح!');

    }
}
