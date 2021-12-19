<?php

namespace App\Controller;

use App\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class NavbarController extends AbstractController
{
    public function navbar()
    {
        $name = $this->getUser()->getUserIdentifier();

        $file = $this->getDoctrine()->getRepository(File::class)->findBy(
            ['owner' => $name], ['name' => 'ASC']
        );

        return $this->render('navbar/index.html.twig', [
            'controller_name' => 'NavbarController',
            'utilisateur' => $name,
            'files' => $file,
        ]);
    }
}
