<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    private const PRODUCTS = [
        [
            'id' => 1,
            'name' => 'IPhone',
            'description' => 'IPhone18 Pro Max',
            'price' => 2000
        ],
        [
            'id' => 2,
            'name' => 'Microphone',
            'description' => 'Microphone Razer',
            'price' => 600
        ],
        [
            'id' => 3,
            'name' => 'Laptop',
            'description' => 'Gaming Laptop',
            'price' => 4000
        ]
    ];

    /**
     * @return mixed
     */
    public function getProducts(): mixed
    {
        return response()->json(self::PRODUCTS, Response::HTTP_OK);
    }

    /*
     * @param string $id
     * @return mixed
     */
    public function getProductItem(string $id): mixed
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return response()->json([
                'data' => ['error' => 'Product not found by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $product], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function createProject(Request $request): mixed
    {
        $requestData = json_decode($request->getContent(), true);

        $productId = random_int(1, 100);

        $newProductData = [
            'id' => $productId,
            'name' => $requestData['name'] ?? '',
            'description' => $requestData['description'] ?? '',
            'price' => $requestData['price'] ?? 0
        ];

        return response()->json([
            'data' => $newProductData
        ], 201);
    }

    public function updateProduct(Request $request, string $id)
    {
        $requestData = $request->all();

        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return response()->json([
                'data' => ['error' => 'Product not found by id ' . $id]
            ], 404);
        }

        $updatedProductData = [
            'id' => $product['id'],
            'name' => $requestData['name'] ?? $product['name'],
            'description' => $requestData['description'] ?? $product['description'],
            'price' => $requestData['price'] ?? $product['price']
        ];

        return response()->json([
            'data' => $updatedProductData
        ], 200);
    }

    public function deleteProduct(string $id)
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return response()->json([
                'data' => ['error' => 'Product not found by id ' . $id]
            ], 404);
        }

        return response()->json([
            'data' => [
                'message' => 'Product deleted successfully',
                'product' => $product
            ]
        ], 200);
    }

    private function getProductItemById(array $products, string $id): ?array
    {
        foreach ($products as $product) {
            if ((string) $product['id'] === $id) {
                return $product;
            }
        }

        return null;
    }
}
