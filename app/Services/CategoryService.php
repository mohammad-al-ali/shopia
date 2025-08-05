<?php
namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryService
{
    public function __construct(protected CategoryRepository $categoryRepository) {}
private function prepareCategoryData(Request $request): array
{
        $data=$request->only([
           'name',
           'description',
            'parent_category_id'
        ]);
        $data['updated_at']=now();
        return $data;
}
public function handleStore(Request $request): void
{
        $data=$this->prepareCategoryData($request);
        $this->categoryRepository->create($data);
}
    public function updateCategory(Request $request): bool
    {

        $category = $this->categoryRepository->find($request->id);
        $data=$this->prepareCategoryData($request);
        return $this->categoryRepository->update($category, $data);
    }

}
