<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getAllPaginated($perPage = 10)
    {
        return Category::orderBy('id', 'DESC')->paginate($perPage);
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data)
    {
        return $category->update($data);
    }

    public function delete($id)
    {$category=$this->find($id);
        return $category->delete();
    }
}
