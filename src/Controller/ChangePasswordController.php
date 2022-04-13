<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ChangePasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mon-espace-client/modifier-mot-de-passe', name: 'change_password')]
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $notification = null;

        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $old_password = $form->get('old_password')->getData();

            if($hasher->isPasswordValid($user, $old_password)){
                $new_password = $form->get('new_password')->getData();
                $password = $hasher->hashPassword($user, $new_password);

                $user->setPassword($password);

                $this->entityManager->flush();
                $notification = 'Votre mot de passe a bien été modifié !';
            } else {
                $notification = 'Oups, il y a eu un problème ... Vérifiez vos saisies et recommencez.';
            }
        }

        return $this->render('change_password/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
