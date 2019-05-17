<?php

namespace App\Http\Controllers;

// Auth
use Illuminate\Support\Facades\Auth;

use App\Contracts\CategoriesContract;
use App\Models\Category;

use App\Http\Requests\DisplayNameRequest;

class CategoriesController extends Controller
{
    private $categoriesUtility;

    public function __construct(CategoriesContract $categoriesContract)
    {
        $this->categoriesUtility = $categoriesContract;
    }

    public function createCategory(DisplayNameRequest $request)
    {
        $user = Auth::user();
        $organizationId = $user->getOrganizationIdAuthorizeAdmin();
        return $this->categoriesUtility->createCategory($organizationId, $request['display_name']);
    }

    public function allCategory()
    {
        $user = Auth::user();
        $organizationId = $user->getOrganizationIdAuthorizeAdmin();
        return $this->categoriesUtility->allCategory($organizationId);
    }

    public function updateCategory(DisplayNameRequest $request, Category $category)
    {
        $user = Auth::user();
        $user->getOrganizationIdAuthorizeAdmin();
        $user->authorizeCategory($category);
        return $this->categoriesUtility->updateCategory($category, $request['display_name']);
    }

    public function deleteCategory(Category $category)
    {
        $user = Auth::user();
        $user->getOrganizationIdAuthorizeAdmin();
        $user->authorizeCategory($category);
        
        return $this->categoriesUtility->deleteCategory($category);
    }
}
