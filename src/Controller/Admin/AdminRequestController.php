<?php

namespace App\Controller\Admin;

use Doctrine\DBAL\Connection;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Embeded Controller
 * Get info about BDD
 */
class AdminRequestController extends AbstractController
{
        /**
         * get information on Database
         *
         * @param Connection $connection
         * @return Response
         */
        public function sizeBase(Connection $connection) : Response
        {

                $sql = " SELECT TABLE_SCHEMA AS DB_Name, 
                        count(TABLE_SCHEMA) AS Total_Tables, 
                        SUM(TABLE_ROWS) AS Total_Tables_Row, 
                        ROUND(sum(data_length + index_length)/1024/1024,2) AS DB_Size
                        FROM information_schema.TABLES 
                        WHERE TABLE_SCHEMA = 'dev'
                        GROUP BY TABLE_SCHEMA ";


                $tables = $connection->fetchAllAssociative($sql); 

               
            return $this->render('admin/_sizeBase.html.twig', [
                'tables' => $tables
            ]);
        }
}