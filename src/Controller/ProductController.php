<?php

namespace App\Controller;

use App\Resources\ProductResource;
use App\Repository\ProductRepository;
use App\Requests\ProductRequest;
use App\Services\ProductService;
use App\Traits\HttpResponsable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    use HttpResponsable;
    private $productRepository;
    private $productServices;

    public function __construct(ProductRepository $productRepository, ProductService $productServices)
    {
        $this->productRepository = $productRepository;
        $this->productServices = $productServices;
    }

    /**
     * @Route("products", name="get_all_pets", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $result2 = $this->productRepository->findAll();
        $result = $this->productServices->getAllProducts();

        return new JsonResponse(ProductResource::collection($result), Response::HTTP_OK);
    }

    /**
     * @Route("product", name="add_product", methods={"POST"})
     */
    public function add(ProductRequest $request): JsonResponse
    {
        $product = $this->productServices->createProduct($request);
        return $this->makeResponseCreated(ProductResource::create($product), 'Product created!');
    }

    /**
     * @Route("product/{id}", name="get_one_pet", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $product = $this->productRepository->findOneBy(['id' => $id]);
        return new JsonResponse($product, Response::HTTP_OK);
    }



    /**
     * @Route("product/{id}", name="update_pet", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $product = $this->productRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $product->setName($data['name']);
        empty($data['price']) ? true : $product->setPrice($data['price']);


        $updatedPet = $this->productRepository->updatePet($product);

        return new JsonResponse(['status' => 'Product updated!'], Response::HTTP_OK);
    }

    /**
     * @Route("product/{id}", name="delete_pet", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $product = $this->productRepository->findOneBy(['id' => $id]);

        $this->productRepository->removePet($product);

        return new JsonResponse(['status' => 'Product deleted'], Response::HTTP_OK);
    }
}
