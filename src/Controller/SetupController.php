<?php

namespace App\Controller;

use App\Form\MakePageFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class SetupController extends AbstractController
{
    #[Route('/setup', name: 'setup')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(MakePageFormType::class);
        $form->handleRequest($request);

        return $this->render('setup/index.html.twig', [
            'controller_name' => 'SetupController',
            'formSetup'=> $form->createView(),
        ]);
    }

}
