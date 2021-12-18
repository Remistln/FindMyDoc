<?php

namespace App\Controller;

use App\Entity\Documentation;
use App\Entity\File;
use App\Form\MakePageFormType;
use App\Form\RegistrationFormType;
use App\Repository\FileRepository;
use App\Services\TableFile;
use PhpParser\Node\Expr\New_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Forms;


class SetupController extends AbstractController
{
    #[Route('/setup', name: 'setup')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(MakePageFormType::class);
        $form->handleRequest($request);

//        $appel = @file_get_contents("http://127.0.0.1:8000/api/files");
//        $appel = json_decode($appel, true);
//        $tableau = [];
//        $files = $appel["hydra:member"];
//        foreach($files as $fileTableau)
//        {
//            $service = (new File())
//                ->setId($fileTableau['id'])
//                ->setName($fileTableau['name'])
//            ;
//            array_push($tableau, $service);
//        }

        $file = $this->getDoctrine()->getRepository(File::class)->findAll();
        dd($file);

        return $this->render('setup/index.html.twig', [
            'controller_name' => 'SetupController',
            'formSetup'=> $form->createView(),
        ]);
    }

}
