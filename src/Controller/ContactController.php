<?php

namespace App\Controller;

use App\Class\Mail;
use App\Entity\User;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response
    {
        $admin_email = $this->entityManager->getRepository(User::class)->findAdminEmail()[0]['email'];
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        $mail = new Mail();

        if ($form->isSubmitted() && $form->isValid()) {
//        Getting infos for the email
            $from_email = $form->get('email')->getData();
            $from_name = $form->get('firstName')->getData().' '.$form->get('lastName')->getData();;
            $subject = $form->get('subject')->getData();
            $establishment = $form->get('establishment')->getData()->getName();
            $message = $form->get('message')->getData();

            $mail->send($admin_email, $from_email, $from_name, $subject, $establishment, $message);
            $this->addFlash('success', 'Votre message a bien été envoyé. Notre équipe va vous répondre dans les plus brefs délais.');
        } else {
            $this->addFlash('error', 'Il semble y avoir eu un problème avec votre message. Veuillez réessayer.');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
