<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;

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
    public function new(Request $request, EntityManagerInterface $manager) : Response{
        $product = new Product;

        $form = $this->createForm(ProductType::class, $product); // A entidade Product estará linkada com os dados do formulário

        $form->handleRequest($request); // Formulário vai receber dados da requisição

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($product);


            $manager->flush(); // Consulta a base de dados, inclui o registro da entidade, e atualiza o objeto da entidade;

            $this->addFlash('sucesso', 'Formulário enviado com êxito!');

            return $this->redirectToRoute('product_show', ['id' => $product->getId()], 302);

        }
        
        return $this->render('product/new.html.twig', ['form' => $form]);
    }

    #[Route('product/{id<\d+>}/edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $manager) : Response{
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();

            $this->addFlash('sucesso','');
        }

    }
}
