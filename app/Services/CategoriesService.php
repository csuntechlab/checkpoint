<?php

namespace App\Services;

use App\Contracts\CategoriesContract;
use App\Models\Category;
use App\Exceptions\DuplicateName;
use Illuminate\Database\QueryException;
use App\DomainValueObjects\UUIDGenerator\UUID;
use \Illuminate\Support\Facades\DB;

class CategoriesService implements CategoriesContract
{

    public function generateName($displayName)
    {
        $name = preg_replace("/[^a-z0-9_]+/i", "", $displayName);
        return strtolower($name);
    }

    public function createCategory($organizationId, $displayName)
    {
        $name = $this->generateName($displayName);

        $categoryId = UUID::generate();

        try {
            return Category::create([
                'id' => $categoryId,
                'organization_id' => $organizationId,
                'name' => $name,
                'display_name' => $displayName
            ]);
        } catch (\Exception $e) {
            if ($e instanceof QueryException) { // Handles duplicate
                throw new DuplicateName($displayName);
            }
            throw $e;
        }
    }

    public function allCategory($organizationId)
    {
        try {
            return Category::where('organization_id', $organizationId)->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateCategory(Category $category, $displayName)
    {
        $name = $this->generateName($displayName);

        return DB::transaction(function () use ($category, $displayName, $name) {
            try {
                $category->display_name = $displayName;
                $category->name = $name;
                $category->save();
            } catch (\Exception $e) {
                if ($e instanceof QueryException) { // Handles duplicate
                    throw new DuplicateName($displayName);
                }
                throw $e;
            }
            return $category;
        });
    }

    public function deleteCategory(Category $category)
    {
        try {
            $category->delete();
        } catch (\Exception $e) {
            throw $e;
        }
        return ['message' => 'Category was deleted.'];
    }
}
