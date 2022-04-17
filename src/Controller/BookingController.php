<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Suites;
use App\Form\BookingType;
use App\Form\OneSuiteBookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/reserver', name: 'booking')]
    public function index(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $newBooking = new Booking();
        $form = $this->createForm(BookingType::class, $newBooking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now = new \DateTime();
            $reference = $now->format('dmY') . '-' . uniqid();
            $total_nights = date_diff($form->get('dateStart')->getData(), $form->get('dateEnd')->getData());
            $total_price = 400 * $total_nights->days;

//            Setting the data
            $newBooking = $form->getData();
            $newBooking->setCustommer($this->getUser());
            $newBooking->setCreatedAt($now);
            $newBooking->setReference($reference);

            dd($_POST);

//            Persist and flush the booking to the DB
            $this->entityManager->persist($newBooking);
            $this->entityManager->flush();
        }

        return $this->render('booking/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reserver/{id}', name: 'oneSuiteBooking')]
    public function bookOneSuite(Request $request, $id): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $suite = $this->entityManager->getRepository(Suites::class)->findOneById($id);
        $newBooking = new Booking();
        $newBooking->setSuite($suite);


        $form = $this->createForm(OneSuiteBookingType::class, $newBooking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now = new \DateTime();
            $reference = $now->format('dmY') . '-' . uniqid();
            $total_nights = date_diff($form->get('dateStart')->getData(), $form->get('dateEnd')->getData());
            $total_price = $suite->getPrice() * $total_nights->days;

//            Setting the data
            $newBooking = $form->getData();
            $newBooking->setCreatedAt($now);
            $newBooking->setReference($reference);
            $newBooking->setCustommer($this->getUser());
            $newBooking->setTotalPrice($total_price);
            $newBooking->setEstablishment($suite->getEstablishment());

            if (!$this->entityManager->getRepository(Booking::class)->findBySuite($newBooking->getSuite())) {
                $this->entityManager->persist($newBooking);
                $this->entityManager->flush();
                $this->addFlash('success', 'Votre réservation a bien été prise en compte.');
            } else if (!$this->entityManager->getRepository(Booking::class)->findByVacancy($newBooking->getDateStart(),
                $newBooking->getDateEnd())) {
//            Persist and flush the booking to the DB
                    $this->entityManager->persist($newBooking);
                    $this->entityManager->flush();
                    $this->addFlash('success', 'Votre réservation a bien été prise en compte.');
                } else {
                    $this->addFlash('error', 'La suite choisie n\'est pas disponible à ces dates. ');
                    unset($newBooking);
                }

//                return $this->redirectToRoute('account');
            }

            return $this->render('booking/oneSuite.html.twig', [
                'form' => $form->createView(),
                'suite' => $suite
            ]);
        }

    }


