<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use LDAP\Result;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product', methods:['GET'])]
    public function index(ProductsRepository $repository, Paginatorinterface $paginator, Request $request): Response
    {
        $products= $repository->findAll();
        $productlist = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            9,
        );


        // dd($products);
        return $this->render('pages/product/index.html.twig', [
            'products' => $productlist

        ]);
    }

    #[Route('/product/new','product.new',methods:['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager) : Response {

    

        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);

        $form->handleRequest($request);
        if($form-> isSubmitted() && $form->isValid()){
            $product = $form->getData();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash(
                'Success',
                'Product added'
            );

            return $this->redirectToRoute('app_product');
            
        }
        return $this->render('pages/product/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/product/edition/{id}', 'product.edit', methods:['GET','POST'])]
    public function edit(ProductsRepository $repository, int $id, Request $request, EntityManagerInterface $manager) : Response {
        $product = $repository->findOneby(["id" => $id]);
        $form = $this->createForm(ProductsType::class, $product);
        
        $form->handleRequest($request);
        if($form-> isSubmitted() && $form->isValid()){
            $product = $form->getData();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash(
                'Success',
                'Product Edited'
            );

            return $this->redirectToRoute('app_product');
            
        }
        return $this->render('pages/product/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/product/delete/{id}', 'product.delete', methods: ['GET'])]
    public function delete(ProductsRepository $repository, int $id, EntityManagerInterface $manager) : Response {
        $product = $repository->findOneBy(["id"=> $id]);
        $manager->remove($product);
        $manager->flush();

        $this->addFlash(
            'Success',
            'Product Deleted'
        );

        return $this->redirectToRoute('app_product');
    }

} 