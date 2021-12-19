<?php

namespace App\Controller;

use App\Entity\Documentation;
use App\Entity\File;
use App\Form\MakePageFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ModifyFileController extends AbstractController
{
    #[Route('/file/modify/{name}', name: 'modify_file')]
    public function index($name, Request $request, SluggerInterface $slugger): Response
    {
        // Pour chaque doc lié a cette page, il va les mettre dans une liste pour la passer dans la vue twig
        $username = $this->getUser()->getUserIdentifier();
        $em = $this->getDoctrine()->getManager();

        $get = $em
            ->getRepository(File::class)
            ->findOneBy(
                ['owner' => $username, 'name' => $name]
            );
        $liste = $get->getDocList();
        $listdoc = [];

        if ($liste){
            foreach ($liste as $doc){
                $document = $em->getRepository(Documentation::class)->findOneBy(['id' => $doc]);
                array_push($listdoc, $document);
            }
        }

        // Creer le formulaire d'ajout de doc
        $form = $this->createForm(MakePageFormType::class);
        $form->handleRequest($request);

        // Si le formulaire est submit et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('fichier')->getData();
            dd($form->get('fichier')->getData())

            //Recupere le nom du fichier avec l'extension
            $originalFilename = pathinfo($data->getClientOriginalName(), PATHINFO_FILENAME);

            // Donne un nom unique au fichier
            $safeFilename = $slugger->slug($originalFilename);
            $docname = $safeFilename.'-'.uniqid().'.'.$data->guessExtension();

            //On le deplace dans le bon dossier
            try {
                $data->move(
                    $this->getParameter('upload_directory') . $username,
                    $docname
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            //Ajout dans la database
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
