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
        return $this->render('file/file.html.twig', [
            'controller_name' => 'FileController',
            'nom' => strtoupper($name),
            'listdoc' => $listdoc
        ]);
    }

    #[Route('/file/delete/{id}', name: 'file_delete_{id}')]
    public function delete($id){
        $username = $this->getUser()->getUserIdentifier();
        $em = $this->getDoctrine()->getManager();

        $deletefile = $em
            ->getRepository(File::class)
            ->find($id);

        $this->getDoctrine()->getManager()->remove($deletefile);
        $em->flush();

        $liste = $deletefile->getDocList();
        foreach ($liste as $doc){
            $document = $em->getRepository(Documentation::class)->find($id);;
            $chemin = "../public/uploads/" . $username . '/' . $document->getName() . '.' . $document->getExtention();
            unlink($chemin);
            $this->getDoctrine()->getManager()->remove($document);
            $em->flush();
        }

        return $this->render('file/index.html.twig', [
            'controller_name' => 'FileController',
        ]);
    }
}
