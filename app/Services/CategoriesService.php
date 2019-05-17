<?php

namespace App\Services;

use App\Contracts\CategoriesContract;
use App\Models\Category;

class CategoriesService implements CategoriesContract
{
    public function createCategory($organizationId, $displayName)
    {
        return Category::create([
            'organization_id' => $organizationId,
            'name' => $name,
            'display_name' => $displayName
        ]);
    }

    public function allCategory($organizationId)
    {
        return Category::where('organization_id', $organizationId)->get();
    }

    public function updateCategory($organizationId, $displayName, Category $category)
    {
        return Category::create([]);
    }

    public function deleteCategory(Category $category)
    {
        return Category::create([]);
    }
}
