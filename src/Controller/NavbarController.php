<?php

namespace App\Controller;

use App\Entity\File;
use App\Services\TableFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavbarController extends AbstractController
{
    public function navbar()
    {
        $files = new TableFile();
        $name = $this->getUser()->getUserIdentifier();
        $listFiles = $files->FileByOwner($name);

        return $this->render('navbar/index.html.twig', [
            'controller_name' => 'NavbarController',
            'pages' => $listFiles,
        ]);
    }
}
