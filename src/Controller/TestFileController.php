<?php

namespace App\Controller;

use App\Entity\Documentation;
use App\Form\UploadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TestFileController extends AbstractController
{
    #[Route('/test/file', name: 'test_file')]
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        $doc = new Documentation();
        $form = $this->createForm(UploadType::class, $doc);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $pdf = $form->get('name')->getData();
            if ($pdf) {
                $originalFilename = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $name = $safeFilename.'-'.uniqid().'.'.$pdf->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $pdf->move(
                        $this->getParameter('upload_directory_img'),
                        $name
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $doc->setName($name);
            }

            // ... persist the $product variable or any other work

            return $this->redirectToRoute("test_display");

        }


        return $this->render('test_file/index.html.twig', [
            'controller_name' => 'TestFileController',
            'form' => $form->createView(),
        ]);
    }
}
