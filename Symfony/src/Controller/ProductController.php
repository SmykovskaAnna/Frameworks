<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController
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
     * @return JsonResponse
     */
    #[Route('/products', name: 'get_products', methods: [Request::METHOD_GET])]
    public function getProducts(): JsonResponse
    {
        return new JsonResponse(['data' => self::PRODUCTS], Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/products/{id}', name: 'get_product_item', methods: [Request::METHOD_GET])]
    public function getProductItem(string $id): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return new JsonResponse(['data' => ['error' => 'Product not found by id' . $id]], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['data' => $product], Response::HTTP_OK);
    }

    #[Route('/products', name: 'post_products', methods: [Request::METHOD_POST])]
    public function createProject(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $productId = random_int(1, 100);

        $newProductData = [
            'id' => $productId,
            'name' => $requestData['name'] ?? '',
            'description' => $requestData['description'] ?? '',
            'price' => $requestData['price'] ?? 0
        ];

        return new JsonResponse(['data' => $newProductData], Response::HTTP_CREATED);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/products/{id}', name: 'put_product', methods: [Request::METHOD_PUT])]
    public function updateProduct(Request $request, string $id): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return new JsonResponse(
                ['data' => ['error' => 'Product not found by id' . $id]],
                Response::HTTP_NOT_FOUND
            );
        }

        $updatedProductData = [
            'id' => $product['id'],
            'name' => $requestData['name'] ?? $product['name'],
            'description' => $requestData['description'] ?? $product['description'],
            'price' => $requestData['price'] ?? $product['price']
        ];

        return new JsonResponse(['data' => $updatedProductData], Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/products/{id}', name: 'delete_product', methods: [Request::METHOD_DELETE])]
    public function deleteProduct(string $id): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return new JsonResponse(
                ['data' => ['error' => 'Product not found by id' . $id]],
                Response::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse(
            ['data' => ['message' => 'Product deleted successfully', 'product' => $product]],
            Response::HTTP_OK
        );
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
