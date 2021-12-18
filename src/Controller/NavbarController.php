<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\User;
use App\Services\TableFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavbarController extends AbstractController
{
    public function navbar()
    {
        $name = $this->getUser()->getUserIdentifier();

        $file = $this->getDoctrine()->getRepository(File::class)->findBy(
            ['owner' => $name]
        );;

        return $this->render('navbar/index.html.twig', [
            'controller_name' => 'NavbarController',
            'files' => $file,
        ]);
    }
}
