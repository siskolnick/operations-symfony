<?php
namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use App\Services\TrackingLogService;

class OperationRESTClientService
{
    const HTTP_STATUS_OK = 200;

    private $client;
    private $params;
    private $id_generated = 0;
    private $logOperation;
    
    public function __construct(HttpClientInterface $client, ContainerBagInterface $params,TrackingLogService $trackingAlertas )
    {
        $this->client = $client;
        $this->params = $params;
        $this->logOperation = $trackingAlertas;
    }

    public function getOperations(): array
    {
        $response = $this->client->request(
            'GET',
            $this->params->get('app.REST_Endpoint')
        );

        $content = json_decode($response->getContent());
        return $content->data;
    }

    public function createOperation(FormInterface $form): bool
    {
        if( $form->isSubmitted() && $form->isValid()){
            $operation = $form->getData();
            $response = $this->client->request(
                'POST',
                $this->params->get('app.REST_Endpoint'),
                [
                    'body' =>  [
                        'operator1' => $operation->getOperator1(),
                        'operator2'=> $operation->getOperator2(),
                        'type_id'=> $operation->getTypeId(),
                    ],
                ]
            );

            $statusCode = $response->getStatusCode();
            if( $statusCode == self::HTTP_STATUS_OK) //200-ok
            {
                $content = json_decode($response->getContent());
                $this->id_generated = $content->id != null? $content->id : 0;
                if( $this->id_generated == 0){
                    $form->addError(new FormError('Can\'t recover id of created operation (Node REST)'));    
                    return false;
                }
                
                $this->logOperation->operationCreated($this->id_generated,$operation);
                return true;
            }else{
                $form->addError(new FormError('Error calling operation service (Node REST)'));
                return false;
            }
        }
        return false;
    }

    public function getIdGenerated(): int
    {
        return $this->id_generated;
    }
}