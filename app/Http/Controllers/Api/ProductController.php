<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(){
        return $this->productRepository->all();
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:25|unique:products',
            'price' => 'required|numeric',
            'categories' => 'required|array',
            'images' => 'nullable|array'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => ResponseAlias::HTTP_NOT_ACCEPTABLE,
                'statusText' => 'Failed',
                'errors' => $validator->getMessageBag()->getMessages()
            ]);
        }
        return $this->productRepository->store($request);
    }
}
