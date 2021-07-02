<?php
namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class OperationRESTClientService
{
    const HTTP_STATUS_OK = 200;

    private $client;
    private $params;
    private $id_generated = 0;
    
    public function __construct(HttpClientInterface $client, ContainerBagInterface $params)
    {
        $this->client = $client;
        $this->params = $params;
    }

    public function getOperations(): array
    {
        $response = $this->client->request(
            'GET',
            $this->params->get('app.REST_Endpoint')
        );

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = json_decode($response->getContent());
        //$content  = $response->toArray();
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
            // $contentType = $response->getHeaders()['content-type'][0];
            //$content = $response->toArray();
            if( $statusCode == self::HTTP_STATUS_OK) //ok
            {
                $content = json_decode($response->getContent());
                $this->id_generated = $content->id != null? $content->id : 0;
                if( $this->id_generated == 0){
                    $form->addError(new FormError('Can\'t recover id of created operation (Node REST)'));    
                    return false;
                }
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