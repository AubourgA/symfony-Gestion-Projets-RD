<?php

namespace App\Controller;

use App\Entity\Materials;
use App\Form\MaterialsType;
use App\Repository\MaterialsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaterialsController extends AbstractController
{
    /**
     * display all Materials
     *
     * @return Response
     */
    #[Route('/materials', name: 'app_materials')]
    public function index(Request $request, MaterialsRepository $mr, PaginatorInterface $paginator): Response
    {
        
        //pagination
        $materials = $paginator->paginate(
            $mr->findAll(),      
            $request->query->getint('page', 1),
            7
            
    );
    
        return $this->render('materials/index.html.twig', [
            'materials' => $materials,
        ]);
    }

    #[Route('/materials/new', name: 'app_new_materials')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {

       $materials = new Materials();
       
       $form = $this->createForm(MaterialsType::class, $materials);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()) {
          $material = $form->getData();

          $em->persist($material);
          $em->flush();

          $this->addFlash(
              'success',
              'Your adding was created with successfull !'
          );

         return $this->redirectToRoute('app_materials');
       }
  


        return $this->render('materials/new.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * This methods allows to modify element
     */
    #[Route('/materials/edit/{id}', name: 'app_edit_materials', methods : ['GET','POST'])]
    public function edit(Request $request, EntityManagerInterface $em, MaterialsRepository $repo, int $id ) : Response
    {


        //recuperer l'element dans la BDD en fonction de l'id passer en POST/GET
        $materials = $repo->findOneBy(['id'=> $id]);

        //vERIFICATION SI L ID EXISTE
        if(empty($materials)) {
           
            throw $this->createNotFoundException('La page n\'existe pas');
        }
       
        //creer le formulaire en fonction des champs de du form
        $form = $this->createForm(MaterialsType::class, $materials);

        //recupere les donnée du formualaire
        $form->handleRequest($request);

        //Si form est valid et sousmis, envois les modif a la BDD
        if($form->isSubmitted() && $form->isValid()) {
            $material = $form->getData();
  
            $em->persist($material);
            $em->flush();
  
            $this->addFlash(
                'success',
                'Your adding was modified with successfully !'
            );
  
           return $this->redirectToRoute('app_materials');
         }


        return $this->render('materials/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * Params converters : Materials $materials au lieu de MaterialRepo et $id
     */
    #[Route('/materials/delete/{id}', name: 'app_delete_materials')]
    public function delete(EntityManagerInterface $em, Materials $materials): Response
    {
        $em->remove($materials);
        $em->flush();

        $this->addFlash(
                'success',
                'Your removing was done with successfully !'
            );

         return $this->redirectToRoute('app_materials');   
    }
}
