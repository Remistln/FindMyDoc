<?php

namespace App\Controller;

use App\Entity\Documentation;
use App\Entity\File;
use phpDocumentor\Reflection\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{

    #[Route('/file', name: 'files')]
    public function index(): Response
    {
        return $this->render('file/index.html.twig', [
            'controller_name' => 'FileController',
        ]);
    }

    #[Route('/file/{name}', name: 'file')]
    public function page($name){

        //recupere une page
        $username = $this->getUser()->getUserIdentifier();
        $em = $this->getDoctrine()->getManager();

        $get = $em
            ->getRepository(File::class)
            ->findOneBy(
                ['owner' => $username, 'name' => $name]
            );

        //Recupere la liste des documents lies a cette page
        $liste = $get->getDocList();
        $listdoc = [];

        //Pour chaque document, le recupere et le met dans une liste pour la passser a la vue twig
        if ($liste){
            foreach ($liste as $doc){
                $document = $em->getRepository(Documentation::class)->findOneBy(['id' => $doc]);
                array_push($listdoc, $document);
            }
        }
        return $this->render('file/file.html.twig', [
            'controller_name' => 'FileController',
            'nom' => strtoupper($name),
            'listdoc' => $listdoc
        ]);
    }

    #[Route('/file/delete/{id}', name: 'file_delete_{id}')]
    public function delete($id){

        // recupere une page
        $username = $this->getUser()->getUserIdentifier();
        $em = $this->getDoctrine()->getManager();

        $deletefile = $em
            ->getRepository(File::class)
            ->find($id);

        //Recupere la liste des documents de la page
        $liste = $deletefile->getDocList();
        if ($liste){
            //Pour chaque document dans la liste
            foreach ($liste as $doc){
                //Recupere le document
                $document = $em->getRepository(Documentation::class)->find($doc);
                //Supprime le fichier physique
                $chemin = "../public/uploads/" . $username . '/' . $document->getName() . '.' . $document->getExtention();
                unlink($chemin);
                //Le retire de la base de donnee
                $this->getDoctrine()->getManager()->remove($document);
                $em->flush();
            }
        }

        //supprime la page dans la base de donnees
        $this->getDoctrine()->getManager()->remove($deletefile);
        $em->flush();

        return $this->render('file/index.html.twig', [
            'controller_name' => 'FileController',
        ]);
    }
}
