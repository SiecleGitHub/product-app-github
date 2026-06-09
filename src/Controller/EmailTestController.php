<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class EmailTestController extends AbstractController
{
    #[Route('/email/test', name: 'app_email_test')]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new Email)
                    ->from('no-reply@example.com')
                    ->to(
                        new Address('dave@example.com', 'Dave')
                        )
                    ->subject('Test Email')
                    ->text('This is a test email.')
                    ->html('<p>This is a <b>test</b> email.</p>');

        $email = (new TemplatedEmail)
                    ->from('no-reply@example.com')
                    ->to(new Address('dave@example.com', 'Dave'))
                    ->subject('Test Email')
                    ->htmlTemplate('email_test/example.html.twig')
                    ->context([
                        'name' => 'Dave'
                    ]);

        $mailer->send($email);

        return $this->render('email_test/index.html.twig', [
            'controller_name' => 'EmailTestController',
        ]);
    }
}
