<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\MakePageFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class SetupController extends AbstractController
{
    #[Route('/setup', name: 'setup')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MakePageFormType::class);
        $form->handleRequest($request);

        //Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            //Creer une nouvelle page de documentation
            $file = new File();
            $fileName = $form->get('NomDeLaPage')->getData();
            $userName = $this->getUser()->getUserIdentifier();
            $liste = [];

            $file->setName($fileName);
            $file->setOwner($userName);
            $file->setDocList($liste);

            //L'enregistre dans la base de donnees
            $entityManager->persist($file);
            $entityManager->flush();

            //Retourne sur la page d'acceuil
            return $this->redirectToRoute('files');
        }

        return $this->render('setup/index.html.twig', [
            'controller_name' => 'SetupController',
            'formSetup'=> $form->createView(),
        ]);
    }

}
