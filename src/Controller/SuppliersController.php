<?php

namespace App\Controller;

use App\Entity\Suppliers;
use App\Form\SuppliersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuppliersController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/suppliers', name: 'app_suppliers')]
    public function infoSuppliers(): Response
    {
        $suppliers = $this->entityManager->getRepository(Suppliers::class)->findAll();

        return $this->render('suppliers/info.html.twig', [
            'suppliers' => $suppliers,
        ]);
    }

    #[Route('/suppliers/new', name: 'supplier_new')]
    public function addNewSupplier(Request $request): Response
    {
        $supplier = new Suppliers();
        $form = $this->createForm(SuppliersType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($supplier);
            $this->entityManager->flush();

            $this->addFlash('success',
                'Le fournisseur a été ajouté avec succès.');

            return $this->redirectToRoute('app_suppliers');
        }

        return $this->render('suppliers/add_supplier.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/suppliers/search', name: 'app_suppliers_filter')]
    public function filterSupplier(Request $request): Response
    {
        $filter = $request->query->get('filter');

        $filteredSuppliers = $this->entityManager
            ->getRepository(Suppliers::class)
            ->findByFilteredSuppliers($filter);

        return $this->render('suppliers/info.html.twig', [
            'suppliers' => $filteredSuppliers,
        ]);
    }
}