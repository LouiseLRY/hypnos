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
            $suite = $this->entityManager->getRepository(Suites::class)->findOneById($_COOKIE['suite']);
            $now = new \DateTime();
            $reference = $now->format('dmY') . '-' . uniqid();
            $total_nights = date_diff($form->get('dateStart')->getData(), $form->get('dateEnd')->getData());
            $total_price = $suite->getPrice() * $total_nights->days;

//            Setting the data
            $newBooking = $form->getData();
            $newBooking->setCustommer($this->getUser());
            $newBooking->setCreatedAt($now);
            $newBooking->setReference($reference);
            $newBooking->setSuite($suite);
            $newBooking->setTotalPrice($total_price);

//            Checking for vacancy
            $bookedDates = $this->entityManager->getRepository(Booking::class)->findByVacancy($newBooking->getDateStart(),
                $newBooking->getDateEnd(), $newBooking->getSuite());

            if (!$bookedDates && $newBooking->getDateStart() > $now) {
                $this->entityManager->persist($newBooking);
                $this->entityManager->flush();
                $this->addFlash('success', 'Votre r??servation a bien ??t?? prise en compte.');
                return $this->redirectToRoute('accountBooking');
            } else {
                $this->addFlash('error', 'La suite choisie n\'est pas disponible ?? ces dates ou vous avez s??lectionn?? une date ant??rieure. ');
                unset($newBooking);
            }
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

            $bookedDates = $this->entityManager->getRepository(Booking::class)->findByVacancy($newBooking->getDateStart(),
                $newBooking->getDateEnd(), $newBooking->getSuite());

            if (!$bookedDates && $newBooking->getDateStart() > $now) {
                $this->entityManager->persist($newBooking);
                $this->entityManager->flush();
                $this->addFlash('success', 'Votre r??servation a bien ??t?? prise en compte.');
                return $this->redirectToRoute('accountBooking');
            } else {
                $this->addFlash('error', 'La suite choisie n\'est pas disponible ?? ces dates ou vous avez s??lectionn?? une date ant??rieure. ');
                unset($newBooking);
            }

        }

        return $this->render('booking/oneSuite.html.twig', [
            'form' => $form->createView(),
            'suite' => $suite
        ]);
    }

    #[Route('/annulation/{id}', name: 'cancelBooking')]
    public function cancel($id): Response
    {
        $booking = $this->entityManager->getRepository(Booking::class)->findOneById($id);
        $arrival = $booking->getDateStart();
        $today = new \DateTime();
        $interval = $today->diff($arrival)->format("%a");

        $cancel = false;

        if ($interval > 3) {
            $this->entityManager->remove($booking);
            $this->entityManager->flush();
            $this->addFlash('success', 'Votre r??servation a bien ??t?? annul??e. Nous esp??rons vous recevoir bient??t chez Hypnos H??tels.');

        } else {
            $this->addFlash('error', 'Vous ne pouvez pas annuler votre r??servation ?? moins de 3 jours de la date 
            d\'arriv??e. Veuillez nous contacter pour tous probl??me.');
        }
        return $this->redirectToRoute('accountBooking');
    }
}


