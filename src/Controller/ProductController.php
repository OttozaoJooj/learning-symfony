<?php

namespace App\Controller;


use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ProductType;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'product_index')]
    public function index(ProductRepository $productRepository): Response
    {
        
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/product/{id<\d+>}', 'product_show')]
    public function show(ProductRepository $repo, $id){
        
        $productFounded = $repo->find($id);

        if($productFounded === null){
            throw $this->createNotFoundException('Produto não Encontrado!');
        }

        return $this->render('product/show.html.twig', ['product' => $productFounded]);

    }

    #[Route('/product/new', name: 'product_new')]
    public function new() : Response{

        $form = $this->createForm(ProductType::class);
        
        return $this->render('product/new.html.twig', ['form' => $form]);
    }
}
