<?php

namespace App\Contracts;

use App\Models\Category;

interface CategoriesContract
{
    public function createCategory($organizationId, $displayName);
    
    public function allCategory();
    
    public function updateCategory($organizationId, $displayName, Category $category);
    
    public function deleteCategory(Category $category);
}
