<?php

namespace App\Repositories;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductRepository implements ProductRepositoryInterface
{
    public function all(): JsonResponse
    {
        $products = Product::orderBy('id', 'DESC')->with(['categories', 'images' => function($q) {
            return $q->orderBy('id', 'DESC');
        }])->get();
        $products = ProductResource::collection($products);
        return response()->json([
            'status' => ResponseAlias::HTTP_OK,
            'statusText' => 'Succeed',
            'data' => $products,
            'message' => 'Fetch products successful'
        ]);
    }

    public function store($data): JsonResponse
    {
        try {
            DB::beginTransaction();
            $product = Product::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'price' => $data['price'],
                'details' => $data['details'],
            ]);

            if (empty($product)){
                throw new Exception('Could not create product');
            }

            if ($data['images']){
                foreach ($data['images'] as $image){
                    $file_path = Storage::disk('public')->put('product_images', $image);
                    $productImage = $product->images()->create([
                        'image_path' => $file_path
                    ]);

                    if (empty($productImage)){
                        throw new Exception('Could not create product image');
                    }
                }
            }

            $product->categories()->sync($data['categories']);
            DB::commit();

            $product = $product->fresh();
            $product = new ProductResource($product->load('categories', 'images'));
            return response()->json([
                'status' => ResponseAlias::HTTP_OK,
                'statusText' => 'Succeed',
                'data' => $product,
                'message' => 'Product created successfully'
            ]);

        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => ResponseAlias::HTTP_BAD_REQUEST,
                'statusText' => 'Failed',
                'errors' => $exception->getMessage()
            ]);
        }
    }

    public function show($slug): JsonResponse
    {
        try {
            $product = Product::where('slug', $slug)->with(['categories', 'images' => function($q) {
                return $q->orderBy('id', 'DESC');
            }])->first();
            if (empty($product)) {
                throw new Exception('Could not find product');
            }

            $product = new ProductResource($product);
            return response()->json([
                'status' => ResponseAlias::HTTP_OK,
                'statusText' => 'Succeed',
                'data' => $product,
                'message' => 'Fetch product successful'
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'status' => ResponseAlias::HTTP_NOT_FOUND,
                'statusText' => 'Failed',
                'errors' => $exception->getMessage()
            ]);
        }
    }

    public function update($data, $slug): JsonResponse
    {
        try {
            DB::beginTransaction();
            $product = Product::where('slug', $slug)->first();
            $productU = $product->update([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'price' => $data['price'],
                'details' => $data['details'],
            ]);

            if (empty($productU)){
                throw new Exception('Could not update product');
            }

            if ($data['images']){
                foreach ($data['images'] as $image){
                    $file_path = Storage::disk('public')->put('product_images', $image);
                    $productImage = $product->images()->create([
                        'image_path' => $file_path
                    ]);

                    if (empty($productImage)){
                        throw new Exception('Could not update product image');
                    }
                }
            }

            $product->categories()->sync($data['categories']);
            DB::commit();

            $product = $product->fresh();
            $product = new ProductResource($product->load('categories', 'images'));
            return response()->json([
                'status' => ResponseAlias::HTTP_OK,
                'statusText' => 'Succeed',
                'data' => $product,
                'message' => 'Product updated successfully'
            ]);

        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => ResponseAlias::HTTP_BAD_REQUEST,
                'statusText' => 'Failed',
                'errors' => $exception->getMessage()
            ]);
        }
    }

    public function destroy($slug): JsonResponse
    {
        try {
            $product = Product::where('slug', $slug)->first();
            if (empty($product)){
                throw new Exception('Product not found');
            }
            $product->delete();
            return response()->json([
                'status' => ResponseAlias::HTTP_OK,
                'statusText' => 'Succeed',
                'message' => 'Product deleted successfully'
            ]);

        } catch (Exception $exception){
            return response()->json([
                'status' => ResponseAlias::HTTP_NOT_FOUND,
                'statusText' => 'Failed',
                'message' => $exception->getMessage()
            ]);
        }
    }
}
