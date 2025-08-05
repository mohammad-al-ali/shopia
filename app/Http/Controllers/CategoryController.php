<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;

class CategoryController extends Controller
{ protected CategoryRepository $categoryRepository ;
    protected CategoryService $categoryService ;
    public function __construct(CategoryRepository $categoryRepository,CategoryService $categoryService){
        $this->categoryRepository=$categoryRepository;
        $this->categoryService=$categoryService;
    }
    public function categories(){
        $categories=$this->categoryRepository->getAllPaginated();
        return view('admin.category.Categories',compact('categories'));
    }
    public function create(){
        return view('admin.category.create');
    }
    public function store(CategoryRequest $request)
    {
        $this->categoryService->handleStore($request);
// ✅ 4. إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.category.categories')->with('status', 'تمت إضافة الفئة بنجاح!');
    }
    public function edit($id){
        $category=$this->categoryRepository->find($id);
        return view('admin.category.edit',compact('category'));
    }
    public function update(categoryRequest $request)
    { $this->categoryService->updateCategory($request);
        return redirect()->route('admin.category.categories')->with('status', 'تمت تعديل الفئة بنجاح!');
    }
    public function delete($id){
       $this->categoryRepository->delete($id);
        return redirect()->route('admin.category.categories')->with('status', 'تمت حذف الفئة بنجاح!');

    }
}
