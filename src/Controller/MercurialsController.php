<?php

namespace App\Controller;

use App\Entity\Suppliers;
use App\Entity\User;
use App\Fetcher\SupplierFetcherInterface;
use App\Service\EmailNotificationServiceInterface;
use App\Service\MercurialServiceInterface;
use App\Service\ProcessFilesImportServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MercurialsController extends AbstractController
{
    public function __construct(
        private SupplierFetcherInterface $suppliersFetcher,
        private Security $security,
        private EmailNotificationServiceInterface $emailNotificationService,
        private ProcessFilesImportServiceInterface $filesImportService,
        private MercurialServiceInterface $mercurialService
    ) {
    }

    #[Route('/import/interface', name: 'app_import_interface')]
    public function showImportInterface(): Response
    {
        $suppliers = $this->suppliersFetcher->getAllSuppliers();

        return $this->render('mercurials/import_interface.html.twig', [
            'suppliers' => $suppliers
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @codeCoverageIgnore
     */
    #[Route('/import', name: 'app_import_file')]
    public function handleImportFile(Request $request, MailerInterface $mailer): Response
    {
        $filesRecovered = $request->files->get('files');

        /** @var User $user */
        $user = $this->security->getUser();

        /** @var Suppliers $supplier */
        $supplier = $this->suppliersFetcher->getSupplierById($request->request->get('supplier'));

        foreach ($filesRecovered as $file) {
            $fileName = $file->getClientOriginalName();

            try {
                $this->filesImportService->processFile($file, $supplier);
            } catch (\Exception $exception) {
                return new Response('Erreur lors du traitement du fichier : '
                    . $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            try {
                $this->mercurialService->createMercurialFile($fileName, $supplier);
            } catch (\Exception $exception) {
                return new Response('Erreur lors de la création du fichier mercurial : '
                    . $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            try {
                $this->emailNotificationService->sendCompletionNotification(
                    $fileName,
                    $user->getEmail(),
                    $supplier->getEmail(),
                    $supplier->getName()
                );
            } catch (\Exception $exception) {
                return new Response('Erreur lors de l\'envoi de la notification de finalisation : '
                    . $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        $this->addFlash(
            'success',
            'L\'importation est terminée avec succès.
            Vous pouvez maintenant consulter vos produits.'
        );

        return $this->redirectToRoute('app_products');
    }
}
