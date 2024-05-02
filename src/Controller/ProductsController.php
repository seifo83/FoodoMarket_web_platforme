<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Suppliers;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ProductsRepository $productsRepository;
    private PaginatorInterface $paginator;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductsRepository $productsRepository,
        PaginatorInterface $paginator
    ) {
        $this->entityManager = $entityManager;
        $this->productsRepository = $productsRepository;
        $this->paginator = $paginator;
    }

    #[Route('/products', name: 'app_products')]
    public function listProducts(Request $request): Response
    {
        $filter = $request->query->get('filter') ?? '';

        $data = $filter !== ''
            ? $this->productsRepository->findByDescriptionOrCode($filter)
            : $this->productsRepository->findAll();

        $products = $this->paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('products/list_products.html.twig', [
            'products' => $products,
            'filter' => $filter
        ]);
    }

    #[Route('/products/add', name: 'app_products_add')]
    public function new(Request $request): Response
    {
        $product = new Products();

        $suppliers = $this->entityManager->getRepository(Suppliers::class)->findAll();

        $form = $this->createForm(ProductsType::class, $product, [
                'suppliers' => $suppliers
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCreatedAt();

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                'Le produit a été ajouté avec succès.'
            );

            return $this->redirectToRoute('app_products');
        }

        return $this->renderForm('products/add_product.html.twig', [
            'product' => $product,
            'form' => $form
        ]);
    }

    #[Route('/{id}/product', name: 'app_products_show')]
    public function show(Products $product): Response
    {
        return $this->render('products/show_product.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/product/edit', name: 'app_products_edit')]
    public function edit(Request $request, Products $product, EntityManagerInterface $entityManager): Response
    {
        $suppliers = $this->entityManager->getRepository(Suppliers::class)->findAll();

        $form = $this->createForm(ProductsType::class, $product, [
            'suppliers' => $suppliers
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdatedAt();

            $entityManager->flush();

            $this->addFlash(
                'success',
                'Le produit a été modifié avec succès.'
            );

            return $this->redirectToRoute('app_products_show', [
                'id' => $product->getId()
            ]);
        }

        return $this->renderForm('products/edit_product.html.twig', [
            'product' => $product,
            'form' => $form
        ]);
    }

    #[Route('/{id}/product/delete', name: 'app_products_delete')]
    public function delete(Request $request, Products $product): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_products');
    }
}
