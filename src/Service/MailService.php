<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;

class MailService{

    public function envoisMail($destinataire, $subject,$message):void{
        $transport = Transport::fromDsn('smtp://charlinenws@gmail.com:gxrerhbdafzzhcor@smtp.gmail.com:587');
        $mailer = new Mailer($transport);
        $email = (new Email())->from('charlinenws@gmail.com')->to($destinataire)->subject($subject)->html($message);
        $mailer->send($email);
    }

}