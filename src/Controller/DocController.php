<?php

namespace App\Controller;

use App\Entity\Documentation;
use App\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocController extends AbstractController
{
    #[Route('/doc', name: 'doc')]
    public function index(): Response
    {
        return $this->render('doc/index.html.twig', [
            'controller_name' => 'DocController',
        ]);
    }

    #[Route('/doc/delete/{id}', name: 'delete_doc')]
    public function delete($id)
    {
        $username = $this->getUser()->getUserIdentifier();

        // Recupere la documentation
        $em = $this->getDoctrine()->getManager();
        $doc = $em
            ->getRepository(Documentation::class)
            ->find($id);

        //Supprime le fichier
        $chemin = "../public/uploads/" . $username . '/' . $doc->getName() . '.' . $doc->getExtention();
        unlink($chemin);

        // Le retire de la base de donnée
        $this->getDoctrine()->getManager()->remove($doc);
        $em->flush();

        // Le retire de la liste des documentation dans l'objet 'file'
        $file = $doc->getFileName();
        $docfile = $em
            ->getRepository(File::class)
            ->findOneBy(
                ['owner' => $username, 'name' => $file]
            );

        $listdoc = $docfile->getDocList();
        $listdoc = array_diff($listdoc, array($id));

        $docfile->setDocList($listdoc);
        $em->flush();

        return $this->redirectToRoute('file', ['name' => $file]);
    }
}
