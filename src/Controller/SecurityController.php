<?php

namespace App\Controller;

use App\Utils\SendMailer;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Form\ResetPasswordRequestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/forgotten-pass', name:'forgotten_password')]
    public function forgottenPassword(
                            Request $request,
                            UserRepository $userRepo,
                            TokenGeneratorInterface $tokenGenerator,
                            EntityManagerInterface $em,
                            SendMailer $SendMailer
                            ): Response
    {
        //creation formulaire
        $form = $this->createForm(ResetPasswordRequestType::class);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            //recupere user par son email
            $user = $userRepo->findOneByEmail($form->get('email')->getData());
            //verification si user
            if($user) {      
                //generer un token
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $em->persist($user);
                $em->flush();
                
                //generer un lien de reinitailisation du mdp
                $url = $this->generateUrl('reset_pass', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
                
                //on envoye un mail
                $content = 'Votre lien de reinitialisation : '.$url;
                $SendMailer->sendEmail($user->getEmail(), 'Reinitalisation de votre mot de passe', $content );

                $this->addFlash('success', 'Email a été envoyé avec success. Veuillez consulter votre boite mail !');
                return $this->redirectToRoute('app_login');
            }
           
            $this->addFlash('danger', 'une erreur est ssurevenu');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/reset_password_request.html.twig', [
            'requestPassForm' => $form->createView()
        ]);
    }

    #[Route('/forgotten-pass/{token}', name:'reset_pass')]
    public function resetPass(
                            string $token,
                            Request $request,
                            UserRepository $userRepo,
                            EntityManagerInterface $em,
                            UserPasswordHasherInterface $passwordHasher
                            ): Response
    {
        // verifie si ce token est dans la bdd
        $user = $userRepo->findOneByResetToken($token);
     
        if($user) {
            $form = $this->createForm(ResetPasswordType::class);

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
              //efface le token de la base car validit 1 seul fois
              $user->setResetToken('');
              //hasher nouveau mot de pass
              $user->setPassword($passwordHasher->hashPassword($user, $form->get('password')->getData()));
              $em->persist($user);
              $em->flush();

            $this->addFlash('success', 'Votre mot de passe a été changé avec success');
            return $this->redirectToRoute('app_login');


            }
            return $this->render('security/reset_password.html.twig', [
                'passForm' => $form->createView()
            ]);
        }

        $this->addFlash('danger', 'Jeton invalide');
        return $this->redirectToRoute('app_login');

    }

}
