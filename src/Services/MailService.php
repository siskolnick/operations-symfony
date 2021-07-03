<?php
namespace App\Services;

use App\Entity\OperationResult;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Twig\Environment;



class MailService
{
     /**
     * @var ContainerBagInterface
     */
    private $params;
    /**
     * @var Environment
     */
    protected $templating;
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    public function __construct(ContainerBagInterface $params,Environment $templating, \Swift_Mailer $mailer)
    {
        $this->params = $params;
        $this->templating = $templating;
        $this->mailer = $mailer;
    }

    public function sendEmailOperationCreated(OperationResult $operation)
    {
        $message = new \Swift_Message('Operation created');
        $message->setFrom('admin@paquete.com');
        $mailsTo = explode(',',$this->params->get('app.mailing_list'));
        $message->setTo($mailsTo);
        $message->setBody(
            $this->templating->render(
                'email/test.html.twig',
                [
                    'operation' =>$operation ,
                    'name' => 'Paquete'
                ]
            ),
            'text/html'
        );

        $this->mailer->send($message);
    }
}