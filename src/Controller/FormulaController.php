<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Results;
use App\Form\ImageType;
use App\Entity\Comments;
use App\Entity\Formulas;
use App\Form\ResultType;
use App\Form\CommentType;
use App\Form\FormulasType;
use App\Entity\MaterialFormula;
use App\Repository\ResultsRepository;
use App\Repository\CommentsRepository;
use App\Repository\FormulasRepository;
use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\MaterialFormulaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

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
                        EntityManagerInterface $em,
                        ImagesRepository $repoImg,
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
        $imageForm = $this->createForm(ImageType::class);
        $imageForm->handleRequest($request);
        if($imageForm->isSubmitted() && $imageForm->isValid()) {
            //on recupere les image tansmise
            $images = $imageForm->get('image')->getData();
         
            //onboucle sur lesimages
            foreach($images as $image) {
                //on genere nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                //on copie le ficher dans le ddossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                //on stocke image dans la base de donnée (le nom);
                $img = new Images();
                $img->setName($fichier);
                $f->addImage($img);

            }
            $em->persist($img);
            $em->flush();
            $this->addFlash(
                'success',
                'Your images was added with successfully !'
            );
         
        }

        //PARTIE IMAGES
        $allImages = $repoImg->findBy(['formula'=> $id]);



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
            'imageForm' => $imageForm->createView(),
            'listeImage' => $allImages
           
        ]);
    }

   
}
