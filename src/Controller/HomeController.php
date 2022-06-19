<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;

use App\Repository\ProjectsRepository;
use App\Repository\MaterialsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(ProjectsRepository $pr,
                          MaterialsRepository $mr,
                          Connection $con
                            ): Response
    {
        

        //affect valeur id si existe
         $user = $this->getUser()  ? $this->getUser()->getId() : null;
      
            /*recuperation project personnel */
            $myProjectinProgress = $pr->getMyProjectInProgress('en cours', $user);
            $myProjectinProgress = implode($myProjectinProgress);
     
            $myProjectForcast = $pr->getMyProjectInProgress('a venir', $user);
            $myProjectForcast = implode($myProjectForcast);
     
            $myProjectOver = $pr->getMyProjectInProgress('terminé', $user);
            $myProjectOver = implode($myProjectOver);

            $myCountProject = $pr->findBy(['User' => $user]);
     
        
        /* recuperation total project*/ 
        $inprogress =  $pr->getInProgress('en cours');
        $inprogress = implode($inprogress);

        $forecast =  $pr->getInProgress('a venir');
        $forecast = implode($forecast);

        $finished =  $pr->getInProgress('terminé');
        $finished = implode($finished);

        
        // recupere le dernier projet en fonction de user.
        $lastProject = $pr->findOneBy( [
            'User' => $user],
            ['id'=> 'DESC']
        );
    
        //recupere le nombre de MP
        $totalMaterial = $mr->findAll();
        
     // data pour le graph 
           //recupere les status pour affecter la clef a la bonne valeur
        $statusType = []; 

          foreach($myCountProject as $status) {
              $statusType[] = $status->getStatus();
         }
         $tabCount = array_count_values($statusType);


         $tabStatus = ['en cours', 'a venir', 'termine', 'suspendu', 'arrete'];

         foreach($tabStatus as $keys) {
           if(isset($tabCount[$keys])) {
                $res[] = $tabCount[$keys];
           } else {
               $res[] = 0;
           }
         }
          //affecte resultat à la variable
         $tabCountStatus = $res;

        return $this->render('home/index.html.twig', [
            'inprogress' => $inprogress,
            'myProjectIP' =>   $myProjectinProgress,
            'forecast' => $forecast,
            'myProjectForcast' =>   $myProjectForcast,
            'finished' => $finished,
            'myProjectOver' =>   $myProjectOver,
            'lastProject' =>$lastProject,
            'allProjects' => $pr->findAll(),
            'myCountProject' => $myCountProject,
            'totalMaterial' => $totalMaterial,
            'tabCountStatus' => json_encode($tabCountStatus)
          
                    ]);
    }


}
