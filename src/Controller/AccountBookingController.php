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
        $user = $this->getUser();
        $bookings = $this->entityManager->getRepository(Booking::class)->findByUser($user);

        return $this->render('account/bookings.html.twig', [
            'bookings' => $bookings,
        ]);
    }

    #[Route('/mon-espace-client/mes-reservations/{id}', name: 'showBooking')]
    public function show($id): Response
    {

        $booking = $this->entityManager->getRepository(Booking::class)->findById($id);

        return $this->render('account/showBooking.html.twig', [
            'booking' => $booking,
        ]);
    }
}
