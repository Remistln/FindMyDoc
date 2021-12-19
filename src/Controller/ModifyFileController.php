<?php

namespace App\Controller;

use App\Entity\Documentation;
use App\Entity\File;
use App\Form\MakePageFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifyFileController extends AbstractController
{
    #[Route('/file/modify/{name}', name: 'modify_file')]
    public function index($name, Request $request): Response
    {
        $username = $this->getUser()->getUserIdentifier();
        $em = $this->getDoctrine()->getManager();

        $get = $em
            ->getRepository(File::class)
            ->findOneBy(
                ['owner' => $username, 'name' => $name]
            );
        $liste = $get->getDocList();
        $listdoc = [];

        foreach ($liste as $doc){
            $document = $em->getRepository(Documentation::class)->findOneBy(['id' => $doc]);
            array_push($listdoc, $document);
        }

        $form = $this->createForm(MakePageFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dump($data['fichier']);
            $doc = new Documentation();
        }

        return $this->render('modify_file/index.html.twig', [
            'modifyForm' => $form->createView(),
            'controller_name' => 'ModifyFileController',
            'nom' => strtoupper($name),
            'listdoc' => $listdoc
        ]);
    }
}
