<?php

namespace App\Services\Helpers\Mail;


use App\Services\Helpers\Utils;
use Exception;
use Illuminate\Http\JsonResponse;

class MailSenderService
{
   private MailerPhpMailer $mailer;

    /**
     * @param MailerPhpMailer $mailer
     */
    public function __construct(MailerPhpMailer $mailer)
    {
        $this->mailer = $mailer;
    }


    public  function sendPartnerCreated($dataSent =[]): JsonResponse|array|int|string
    {
       // dd($dataSent);
        try {
                $data= array(
                    "subject"=>"Creation Compte Agent Partenaire",
                    "title"=>"Bonjour " .  $dataSent['name'] ,
                    "name"=>$dataSent['name'] ,
                    "items"=> array(
                        "Votre compte a la plateforme INTECH API est crée."=>"",
                        "<b>Login</b>    : "=>$dataSent['email'],
                        "<b>Mot de passe</b>    : "=>$dataSent['password'],
                        "<a href=' ".env('ESPACE_ADMIN_PARTNER')."'>Se connecter</a>"=>''
                    )
                );

            $data['to'] = $dataSent['email'];
            $html = view('mail/mail')->with(['data' => $data]);
            $data['content'] = $html->render();
            return $this->mailer->genericSend($data);
        } catch (Exception $e) {
            return  Utils::respond('error',[
                $e->getMessage()
            ]);
        }
    }



}
