<?php

namespace App\Controller;

use App\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{

    #[Route('/file', name: 'files')]
    public function index(): Response
    {
        $files = new File();
        $name = $this->getUser()->getUserIdentifier();
        $listFiles = $files->FileByOwner($name);

        return $this->render('file/index.html.twig', [
            'controller_name' => 'FileController',
            'files' => $listFiles,

        ]);
    }

    #[Route('/file/{name}', name: 'file')]
    public function page($name){
        $page = New File();
    }
}
