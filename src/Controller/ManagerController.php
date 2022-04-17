<?php

namespace App\Controller;

use App\Entity\Suites;
use App\Form\SuitesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/manager/gerer-mon-etablissement', name: 'manager_interface')]
    public function index(): Response
    {
        $manager = $this->getUser();
        $hotel = $manager->getEstablishment();

        $suites = $this->entityManager->getRepository(Suites::class)->findByEstablishment($hotel);

        return $this->render('manager/index.html.twig', [
            'suites' => $suites
        ]);
    }

    #[Route('/manager/ajouter-suite', name: 'manager_addSuite')]
    public function addSuite(Request $request): Response
    {
        $newSuite = new Suites();
        $form = $this->createForm(SuitesType::class, $newSuite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newSuite = $form->getData();

//            Giving the manager's establishment by default to the suite
            $newSuite->setEstablishment($this->getUser()->getEstablishment());


//             Treatment of the image file
            /** @var UploadedFile $imageFile */
            $imageFile = $form['main_image']->getData();

            if ($imageFile) {
                $directory = $this->getParameter('kernel.project_dir') . '/public/uploads';

                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($directory, $newFilename);
                $newSuite->setMainImage($newFilename);
            }

//            Persisting data and flushing
            $this->entityManager->persist($newSuite);
            $this->entityManager->flush();

            return $this->redirectToRoute('manager_interface');
        }


        return $this->render('manager/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/manager/supprimer-suite/{id}', name: 'manager_delSuite')]
    public function delete($id): Response
    {
        $suite = $this->entityManager->getRepository(Suites::class)->findOneById($id);

//        Checking if the suite exists and if it belongs to the Establishment the current manager is in charge of.
        if ($suite && $suite->getEstablishment() === $this->getUser()->getEstablishment()) {
            $this->entityManager->remove($suite);
            $this->entityManager->flush();
        }


        return $this->redirectToRoute('manager_interface');
    }

    #[Route('/manager/details/{id}', name: 'manager_showSuite')]
    public function show($id): Response
    {
        $suite = $this->entityManager->getRepository(Suites::class)->findOneById($id);


        return $this->render('manager/show.html.twig', [
            'suite' => $suite
        ]);
    }

}
