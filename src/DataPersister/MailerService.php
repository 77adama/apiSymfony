<?php
namespace App\DataPersister;

use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class MailerService {

    public function __Construct(MailerInterface $mailer, Environment $twig) 
{
    $this->mailer = $mailer;
    $this->twig = $twig;

// ...
}


public function sendEmail($user, $objet='Creation de compte')
{
    $email = (new Email())
    ->from('hello@gmail.com')
    ->to($user->getEmail())
    //->cc('cc@example.com')
    //->bcc('bcc@example.com')
    //->replyTo('fabien@example.com')
    //->priority(Email::PRIORITY_HIGH)
    ->subject($objet)
    ->html($this->twig->render("mail/index.html.twig", [
        "user" => $user,
    ]));

    $this->mailer->send($email);
}

}