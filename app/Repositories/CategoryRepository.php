<?php

namespace App\Repositories;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $categories = CategoryResource::collection($categories);
        return response()->json([
            'status' => ResponseAlias::HTTP_OK,
            'statusText' => 'Succeed',
            'data' => $categories,
            'message' => 'Fetch category successful'
        ]);
    }
}
