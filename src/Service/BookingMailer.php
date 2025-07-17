<?php

namespace App\Service;

use App\Entity\Booking;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class BookingMailer
{
    private MailerInterface $mailer;
    private Environment $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendStatusUpdate(Booking $booking): void
    {
        $owner = $booking->getDog()?->getOwner();
        if (!$owner || !$owner->getEmail()) {
            return; // Sécurité : on ne tente pas d’envoyer à null
        }

        $subject = match ($booking->getStatus()) {
            Booking::STATUS_CONFIRME => 'Votre réservation est confirmée',
            Booking::STATUS_ANNULE => 'Votre réservation a été refusée',
            default => 'Mise à jour de votre réservation',
        };

        $body = $this->twig->render('emails/emails_status.html.twig', [
            'booking' => $booking,
        ]);

        $email = (new Email())
            ->from('no-reply@cafedeschiens.fr')
            ->to($owner->getEmail())
            ->subject($subject)
            ->html($body);

        $this->mailer->send($email);
    }
}
