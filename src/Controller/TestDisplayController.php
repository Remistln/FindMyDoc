<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestDisplayController extends AbstractController
{
    #[Route('/test/display', name: 'test_display')]
    public function index(): Response
    {
        return $this->render('test_display/index.html.twig', [
            'controller_name' => 'TestDisplayController',
//            'lien' => $this->getParameter('upload_directory_img')
        ]);
    }
}
