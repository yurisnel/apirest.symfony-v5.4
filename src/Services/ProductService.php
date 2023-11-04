<?php

namespace App\Services;

use App\Entity\Category;
use App\Entity\Product;
use App\Requests\ProductRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService
{
      protected $entityManager;

      public function __construct(EntityManagerInterface $entityManager)
      {
            $this->entityManager =  $entityManager;
      }

      public function createProduct(ProductRequest $request)
      {
            $category = new Category();
            $category->setName($request->categoryName);

            $product = new Product();
            $product->setName($request->name);
            $product->setPrice($request->price);
            $product->setCategory($category);

            $this->entityManager->persist($category);
            $this->entityManager->persist($product);

            $this->entityManager->flush();

            return $product;
      }


      public function updateProduct(Product $product, $data)
      {
            // Actualizar el producto con los datos proporcionados
            $product->setName($data['name']);
            $product->setPrice($data['price']);

            $this->entityManager->flush();

            return $product;
      }

      public function deleteProduct(Product $product)
      {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
      }

      public function getProduct($productId)
      {
            $product = $this->entityManager->getRepository(Product::class)->find($productId);
            if (!$product) {
                  return new NotFoundHttpException('No product found for id ' . $productId);
            }

            return $product;
      }

      public function getAllProducts()
      {
            return $this->entityManager->getRepository(Product::class)->findAll();
      }
}
