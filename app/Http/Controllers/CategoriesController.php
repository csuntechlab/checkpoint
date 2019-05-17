<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\CategoriesContract;
use App\Models\Category;

class CategoriesController extends Controller
{
    private $categoriesUtility;

    public function __construct(CategoriesContract $categoriesContract)
    {
        $this->categoriesUtility = $categoriesContract;
    }

    public function createCategory(Request $request)
    {
        return $this->categoriesUtility->createCategory($request);
    }

    public function allCategory()
    {
        return $this->categoriesUtility->allCategory();
    }

    public function updateCategory(Request $request, Category $category)
    {
        return $this->categoriesUtility->updateCategory($request);
    }

    public function deleteCategory(Request $request, Category $category)
    {
        return $this->categoriesUtility->deleteCategory($request);
    }
}
