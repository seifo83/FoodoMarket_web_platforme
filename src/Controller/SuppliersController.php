<?php

namespace App\Controller;

use App\Entity\Suppliers;
use App\Entity\User;
use App\Fetcher\SupplierFetcherInterface;
use App\Form\SuppliersType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class SuppliersController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security,
        private SupplierFetcherInterface $supplierFetcher,
        private PaginatorInterface $paginator
    ) {
    }

    #[Route('/suppliers', name: 'app_suppliers')]
    public function infoSuppliers(Request $request): Response
    {
        $filter = $request->query->get('filter') ?? '';

        $data = $filter !== ''
            ? $this->supplierFetcher->getSupplierByFilter($filter)
            : $this->supplierFetcher->getAllSuppliers();


        $suppliers = $this->paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('suppliers/list_suppliers.html.twig', [
            'suppliers' => $suppliers,
            'filter' => $filter
        ]);
    }

    #[Route('/suppliers/new', name: 'supplier_new')]
    public function addNewSupplier(Request $request): Response
    {
        $supplier = new Suppliers();
        $form = $this->createForm(SuppliersType::class, $supplier);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($user instanceof User && $form->isSubmitted() && $form->isValid()) {
            $supplier->setUser($user);
            $supplier->setCreatedAt();

            $this->entityManager->persist($supplier);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                'Le fournisseur a été ajouté avec succès.'
            );

            return $this->redirectToRoute('app_suppliers');
        }

        return $this->render('suppliers/add_supplier.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
