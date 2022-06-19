<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Formulas;
use App\Entity\Results;
use App\Entity\MaterialFormula;
use App\Form\ResultType;
use App\Form\FormulasType;
use App\Form\CommentType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\MaterialFormulaRepository;
use App\Repository\ResultsRepository;
use App\Repository\CommentsRepository;
use App\Repository\FormulasRepository;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class FormulaController extends AbstractController
{
    #[Route('/projects/{id}/formula', name: 'app_formula')]
    public function index(Request $request, FormulasRepository $frepo, PaginatorInterface $paginator, int $id): Response
    {
        
        //pagination
        $datasFormula = $paginator->paginate(
                $frepo->findBy( ['projects' => $id]),        
                $request->query->getint('page', 1),
                10
        );

        
        return $this->render('formula/index.html.twig', [
           'datasFormula' => $datasFormula
        ]);
    }
    #[Route('/formulas/edit/{id}', name: 'app_edit_formula')]
    public function edit(Formulas $f,
                        Request $request,
                        FormulasRepository $frepo, 
                        EntityManagerInterface $em,
                        ResultsRepository $resrepo, 
                        CommentsRepository $comrepo,
                        MaterialFormulaRepository $repoMF,
                        int $id): Response
    {
        //recupere les info sur la totalite de la formule
        $matForms = $repoMF->findBy(['idformula' => $id]);
        $SumPrice  = 0;
        $SumQtite = 0;
        $pricePerKg = 0;
        // $pourcentInFormula =0;

       //calcul du prix unitaire
        foreach( $matForms as $matForm) {
            
            $SumPrice += (($matForm->getQuantity() * $matForm->getIdMaterial()->getprice()) / 1000); 
           
        }

        //calcul Quantite
        foreach( $matForms as $qt) {
            $SumQtite += ( $qt->getQuantity() );
        }

        //calul prix au Kg
        $pricePerKg = ($SumPrice / $SumQtite) * 1000;
        
        //PARTIE RESULTAT
        $results = new Results();
        
        $results->setFormula($f);
        $formRes = $this->createForm(ResultType::class, $results);
        $formRes->handleRequest($request);

        if( $formRes->isSubmitted() && $formRes->isValid()) {
            $result = $formRes->getData();
            
            $em->persist($result);
            $em->flush();
        }
     
        //affichage des tous les resultat de la formule selctionnée
        $getResults = $resrepo->findBy( ['formula' => $id]);

        //parie AJOUT IMAGE
   


        //PARTIE COMMENTAIRE
        $com = $comrepo->findOneBy(['formula' => $id]);

        $formComment = $this->createForm(CommentType::class, $com);
        $formComment->handleRequest($request);

        if($formComment->isSubmitted() && $formComment->isValid()) {
            $commentData = $formComment->getData();
            $commentData->setFormula($f);
            
            $em->persist($commentData);
            $em->flush();

            $this->addFlash(
                'success',
                'Your comment was added/modified with successfully !'
            );
            return $this->redirectToRoute('app_formula' , ['id' => $f->getProjects()->getId()]);
        }


        return $this->render('formula/edit.html.twig', [
            'id' => $id,
            'f' => $f,
            'matForms' => $matForms,
            'SumPrice' => $SumPrice,
            'SumQtite' => $SumQtite,
            'pricePerKg' => $pricePerKg,
            'formRes' => $formRes->createView(),
            "getResults" => $getResults,
            'formComment' => $formComment->createView(),
           
        ]);
    }
}
