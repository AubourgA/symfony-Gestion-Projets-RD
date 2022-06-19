<?php

namespace App\Controller;

use App\Entity\Tests;
use App\Repository\TestsRepository;
use App\Form\TestsType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(TestsRepository $tr): Response
    {

        $tests = $tr->findAll();


        return $this->render('test/index.html.twig', [
            'tests' => $tests,
        ]);
    }

    #[Route('/test/new', name: 'app_new_test')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $tests = new Tests();
        $form= $this->createForm(TestsType::class, $tests);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();
           
            $em->persist($datas);
            $em->flush();

            $this->addFlash(
                'success',
                'Your adding was created with successfull !'
            );

            return $this->redirectToRoute('app_test');
        }
       


        return $this->render('test/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
