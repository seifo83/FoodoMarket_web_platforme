<?php

namespace App\Tests\Unit\Controller;

use App\Controller\MercurialsController;
use App\Entity\Suppliers;
use App\Fetcher\SupplierFetcher;
use App\Fetcher\SupplierFetcherInterface;
use App\Repository\SuppliersRepository;
use App\Service\EmailNotificationServiceInterface;
use App\Service\MercurialServiceInterface;
use App\Service\ProcessFilesImportServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;

class MercurialsControllerUnitTest extends TestCase
{
    /**
     * @throws TransportExceptionInterface
     */
    public function testHandleImportFile(): void
    {
        // Création des mocks pour les dépendances nécessaires
        $request = $this->createMock(Request::class);
        $security = $this->createMock(Security::class);
        $suppliersFetcher = $this->createMock(SupplierFetcherInterface::class);
        $emailNotificationService = $this->createMock(EmailNotificationServiceInterface::class);
        $filesImportService = $this->createMock(ProcessFilesImportServiceInterface::class);
        $mercurialService = $this->createMock(MercurialServiceInterface::class);
        $suppliersRepositoryMock = $this->createMock(SuppliersRepository::class);

        // Création de l'instance de la classe à tester avec les mocks injectés
        $controller = new MercurialsController(
            $suppliersFetcher,
            $security,
            $emailNotificationService,
            $filesImportService,
            $mercurialService
        );

        // Création d'un fichier factice pour l'upload
        $filePath = './public/mercuriale2.csv'; // Spécifiez le chemin vers votre fichier CSV
        $file = new UploadedFile($filePath, 'mercuriale2.csv');

        // Configuration des mocks pour simuler le comportement attendu


        $supplierFetcher = new SupplierFetcher($suppliersRepositoryMock);

        $supplierId = 123;

        $supplier = new Suppliers();

        $suppliersRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $supplierId])
            ->willReturn($supplier);

        $result = $supplierFetcher->getSupplierById($supplierId);

        /*
        $filesImportService->expects($this->once())
            ->method('processFile');

        $mercurialService->expects($this->once())
            ->method('createMercurialFile');

        $emailNotificationService->expects($this->once())
            ->method('sendCompletionNotification');

        // Appel de la méthode à tester
        //$response = $controller->handleImportFile($request, $this->createMock(MailerInterface::class));

        // Vérification que la méthode retourne une instance de Response
        //$this->assertInstanceOf(Response::class, $response);

        // Vérification du contenu de la réponse si nécessaire

        */
    }

}
