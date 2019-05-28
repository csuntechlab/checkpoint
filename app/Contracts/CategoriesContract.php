<?php

namespace App\Contracts;

use App\Models\Category;

interface CategoriesContract
{
    public function createCategory($organizationId, $displayName);
    
    public function allCategory($organizationId);
    
    public function updateCategory(Category $category, $displayName);
    
    public function deleteCategory(Category $category);
}
