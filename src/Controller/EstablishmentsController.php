<?php

namespace App\Controller;

use App\Entity\Establishment;
use App\Entity\Suites;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EstablishmentsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/nos-etablissements', name: 'establishments')]
    public function index(): Response
    {
        $establishments = $this->entityManager->getRepository(Establishment::class)->findAll();

        return $this->render('establishments/index.html.twig', [
            'establishments' => $establishments
        ]);
    }

    #[Route('/nos-etablissements/{id}', name: 'establishment')]
    public function show($id)
    {
        $establishment = $this->entityManager->getRepository(Establishment::class)->findOneById($id);
        $suites = $this->entityManager->getRepository(Suites::class)->findByEstablishments($id);

        if(!$establishment) {
            return $this->redirectToRoute('establishments');
        }

        return $this->render('establishments/one.html.twig', [
            'establishment' => $establishment,
            'suites' => $suites
    ]);
    }
}
