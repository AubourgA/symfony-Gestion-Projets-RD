<?php

namespace App\Utils;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class SendMailer extends AbstractController 
{
   
    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    /**
     * Send Email function
     *
     * @param string $to
     * @param string $subject
     * @param string $text
     * @return void
     */
    public function sendEmail( string $to, string $subject, string $text ): void                 
    {
        $email = (new Email())
            ->from('adrien.aubourg@hotmail.fr')
            ->to($to)
            ->subject($subject)
            ->text($text);
          
       $this->mailer->send($email);
    }
}