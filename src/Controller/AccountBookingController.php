<?php

namespace App\Controller;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountBookingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/mon-espace-client/mes-reservations', name: 'accountBooking')]
    public function index(): Response
    {
        dd($this->getUser());
        $bookings = $this->entityManager->getRepository(Booking::class)->findBy($this->getUser());

        return $this->render('account/bookings.html.twig', [
            'controller_name' => 'AccountBookingController',
        ]);
    }
}
