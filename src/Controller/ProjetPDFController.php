<?php

namespace App\Controller;

use Dompdf\Dompdf;

use Dompdf\Options;
use App\Entity\Formulas;
use App\Repository\CommentsRepository;
use App\Repository\FormulasRepository;
use App\Repository\MaterialFormulaRepository;
use App\Repository\ResultsRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class ProjetPDFController extends AbstractController
{
    #[Route('/projects/PDF/{id}', name: 'app_projet_rapport')]
    public function index(int $id, ManagerRegistry $manager): Response
    {
        $formulas = $manager->getRepository(Formulas::class)->findBy(['projects' => $id]);
       
        if(empty($formulas)) {
           
            throw $this->createNotFoundException('La page n\'existe pas');
        }
       

        return $this->render('pdfproject/index.html.twig', [
            
           'formulas' => $formulas,
           'id' => $id
        ]);
    }

    #[Route('/projects/generate/{id}', name: 'app_pdf', methods: ['GET', 'POST'])]
    public function generatePDF(int $id, 
                                FormulasRepository $forRepo, 
                                MaterialFormulaRepository $matForm,
                                ResultsRepository $resRepo,
                                CommentsRepository $respoComment,
                                Request $request)
    {
        //recupereation du token du formulaire
        $submittedToken = $request->request->get('token');
        //verification du token entre le formulaire et celui envoyé
        if ($this->isCsrfTokenValid('generate-item', $submittedToken)) {


            //recupereation des resultat de la requette du choix
            $allFormula = $forRepo->findById($request->get('formula'));
             $composition = $matForm->findBy(['idformula' => $request->get('formula')]);
      
             $getResults = $resRepo->findBy( ['formula' => $request->get('formula')]);
             $comments = $respoComment->findBy(['formula' => $request->get('formula')]);
          
             //on defini les option du PDF
             $pdfOptions = new Options();
             //police par défaut
             $pdfOptions->set('DefaultFont', 'Arial');
             $pdfOptions->setIsRemoteEnabled(true);
             $pdfOptions->set('isRemoteEnabled', true);
     
             //on instance dompdf
             $dompdf = new Dompdf($pdfOptions);
            
             $context = stream_context_create([
                 'ssl' => [
                     'verify_peer' => FALSE,
                     'verifiy_peer_name' => FALSE,
                     'allow_self_signed' => TRUE
                 ]
             ]);
             $dompdf->setHttpContext($context);
           
             //on genere le HTML
             $html = $this->renderView('pdfproject/rapport.html.twig', [
                 'formulas' => $allFormula,
                 'matForms' => $composition,
                 'getResults' => $getResults,
                 'comments' => $comments,
                 'id' => $id
             ]);
          
     
             $dompdf->loadHtml($html);
             $dompdf->setPaper('A4', 'portrait');
             $dompdf->render();
     
            
             //on genere un nom de fichier
             $fichier = 'Rapport du projet -'.$id.'-.pdf';
             //on envoie le pdf au nivaigateur
             $dompdf->stream($fichier, [
                 'Attachment' => true
             ]);
             return new Response();
            
        } else {
            throw $this->createNotFoundException('Le formulaire n \'a pas été correctement envoyé');
        }
     }
}
