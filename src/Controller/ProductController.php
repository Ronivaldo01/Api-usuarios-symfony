<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;

/**
* @Route("/products", name="products_")
*/
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="index", Methods={"GET"})
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->json([
            'data' => $products
        ]);
    }

    /**
     * @Route("/{productId}", name="show", Methods={"GET"})
     */
    public function show($productId): Response
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($productId);
        return $this->json([
            'data' => $product
        ]);
    }

    /**
     * @Route("/", name="create", Methods={"POST"})
     */
    public function create(Request $request){
        $productData = $request->request->all();
        $product = new Product();
        $product->setName($productData['name']);
        $product->setDescription($productData['description']);
        $product->setContent($productData['content']);
        $product->setPrice($productData['price']);
        $product->setSlug($productData['slug']);
        $product->setIsActive(true);
        $product->setCreatedAt(new \DateTime("now", new \DateTimeZone('America/Sao_Paulo')));
        $product->setUpdatedAt(new \DateTime("now", new \DateTimeZone('America/Sao_Paulo')));
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($product);
        $doctrine->flush();
        return $this->json([
            'message' => 'Produto criado com sucesso!'
            
        ]);
    }

    /**
     * @Route("/{productId}", name="update", Methods={"PUT", "PATCH"})
     */
    public function update(Request $request, $productId) {
        $productData = $request->request->all();
        $doctrine = $this->getDoctrine();
        $product = $doctrine->getRepository(Product::class)->find($productId);
        $product->setName($productData['name']);
        $product->setDescription($productData['description']);
        $product->setContent($productData['content']);
        $product->setPrice($productData['price']);
        $product->setSlug($productData['slug']);
        $product->setCreatedAt(new \DateTime("now", new \DateTimeZone('America/Sao_Paulo')));
        $product->setUpdatedAt(new \DateTime("now", new \DateTimeZone('America/Sao_Paulo')));
        $manager = $doctrine->getManager();
        $manager->flush();
        return $this->json([
            'message' => 'Produto atualizado com sucesso!'
            
        ]);
    }
        /**
     * @Route("/{productId}", name="delete", Methods={"DELETE"})
     */
    public function delete($productId) {
        $doctrine = $this->getDoctrine();
        $product = $doctrine->getRepository(Product::class)->find($productId);
        $manager = $doctrine->getManager();
        $manager->remove($product);
        $manager->flush();
        return $this->json([
            'message' => 'Produto Deletado com sucesso!'
            
        ]);
    }
    
}
