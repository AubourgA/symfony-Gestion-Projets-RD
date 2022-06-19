<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Entity\Formulas;
use App\Entity\User;
use App\Form\ProjectsType;
use App\Form\FormulasType;
use App\Repository\FormulasRepository;
use App\Repository\UserRepository;
use App\Repository\ProjectsRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ProjetsController extends AbstractController
{
    #[Route('/projets', name: 'app_projets')]
    public function index(ProjectsRepository $pr, 
                          FormulasRepository $fr,
                          ): Response
    {
        // recuperer la liste des projet actif
        $projects = $pr->findBy( [
            'active' => 0,
        ]);

        //reucpere le nombre de formule par projet
        $NbFormulaPerProject = $fr->getNbFormulaByProjet(2);

       
         /*recuepre la liste des project perso et visible public */
         $user = $this->getUser()  ? $this->getUser()->getId() : null;

         $projectCustom = $pr->getCustomProject($user, 1);
        /*VARAIBALE A INJECTER DANS LE TABLEAU projet index */
       

        return $this->render('projets/index.html.twig', [
            'projects' => $projects,
            'projectCustoms' => $projectCustom,
        ]);
    }

    #[Route('/projets/new', name: 'app_new_projets')]
    public function new(Request $request, 
                        EntityManagerInterface $em,
                        ): Response
    {
        
        

        $projects = new Projects();
        $form = $this->createForm(ProjectsType::class, $projects);
      
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()  ) {
            $project = $form->getData();
            $project->setUser($this->getUser());
            $em->persist($project);
            $em->flush();

            $this->addFlash(
                'success',
                'Your adding was created with successfull !'
            );

            return $this->redirectToRoute('app_projets');

        }

        return $this->render('projets/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/projects/edit/{id}', name: 'app_edit_projets', methods : ['GET','POST'])]
    public function edit(Request $request, 
                        EntityManagerInterface $em, 
                        ProjectsRepository $repo, 
                        FormulasRepository $fr,
                        Projects $Project,
                        int $id ) : Response
    {
        //1 - Formulaire principal

        //recuperer l'element dans la BDD en fonction de l'id passer en POST/GET
        $projects = $repo->findOneBy(['id'=> $id]);
       
        
        //creer le formulaire en fonction des champs de du form
        $form = $this->createForm(ProjectsType::class, $projects);

        //recupere les donnée du formualaire
        $form->handleRequest($request);

        //2 - Sous Formulaire Formulation
        $formulas = new Formulas();
        $formulas->setProjects($projects);
       
        $form2 =  $this->createForm(FormulasType::class, $formulas);
        $form2->handleRequest($request);


        if($form2->isSubmitted() && $form2->isValid()) {
            $data = $form2->getData();
            $em ->persist($data);
            $em->flush();

           //recuperer le nombre de formule et l'injecte dans la BDD
            $MAJNbFormule = $fr->getNbFormulaByProjet($id);
            $projects->settestingNumber(implode(" ", $MAJNbFormule));
            $em->persist($projects);
            $em->flush();
            

            $this->addFlash(
                'success',
                'Your new formula was added with successfully !'
            );
            return $this->redirectToRoute('app_formula', ['id' => $id]);
        }

        //Si form est valid et sousmis, envois les modif a la BDD
        if($form->isSubmitted() && $form->isValid()) {
            $projet = $form->getData();
          
            $em->persist($projet);
            $em->flush();
  
            $this->addFlash(
                'success',
                'Your adding was modified with successfully !'
            );
           return $this->redirectToRoute('app_projets');
         }

        return $this->render('projets/edit.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'id' => $id,
        ]);
    }

    #[Route('/projects/desactive/{id}', name: 'app_desactive_materials')]
    public function desactive(EntityManagerInterface $em, ProjectsRepository $repo, int $id ):Response
    {

        //recuperer l'element dans la BDD en fonction de l'id passer en POST/GET
        $project = $repo->findOneBy(['id'=> $id]);
        $project->setActive(1);
        $em->persist($project);
        $em->flush();

        $this->addFlash(
            'success',
            'Your project was archived successfully !'
        );

        return $this->redirectToRoute('app_projets');
    }



    #[Route('/projects/archived/', name: 'app_archived_projets', methods : ['GET','POST'])]
    public function archived(ProjectsRepository $pr) :Response
    {
        $projects = $pr->findBy( [
            'active' => 1,
        ]);

        return $this->render('projets/archived.html.twig', [
            'projects' => $projects,
        ]);
    }




}
