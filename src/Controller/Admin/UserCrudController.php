<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use Doctrine\ORM\EntityManagerInterface;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class UserCrudController extends AbstractCrudController
{

  
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


   /**
    * update form for user and call updatePassword method
    *
    * @param EntityManagerInterface $entityManager
    * @param [type] $entityInstance
    * @return void
    */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->updatePassword($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->updatePassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    /**
     * Generate a hash password for user
     *
     * @param User $user
     * @return void
     */
    private function updatePassword(User $user): void
    {
        if (!$user->getPlainPassword() ) {
          
            return;
        } else {

            $user->setPassword(password_hash($user->getPlainPassword(),PASSWORD_DEFAULT));
        }
      
        
    }


    //ajout une fonction pour configurer le crud
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Utilisateurs')
            ->setEntityLabelInSingular('Utilisateur')
            ->showEntityActionsInlined();
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('Email'),
            TextField::new('FullName'),
            TextField::new('plainPassword', 'New password')
                ->onlyOnForms(),
            ArrayField::new('roles'),
            BooleanField::new('isActive', 'Active User ?'),
            DateTimeField::new('createdAt')
                ->hideOnForm(),
        ];
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions->disable(Action::DELETE);
    }

    
}
