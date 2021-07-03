<?php
namespace App\Services;

use App\Entity\OperationResult;
use App\Services\TrackingLogService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;

class OperationService
{
    private $id_generated = 0;
    private $logOperation;
    
    public function __construct(TrackingLogService $trackingAlertas)
    {
        $this->logOperation = $trackingAlertas;
    }

    public function createOperation(FormInterface $form, EntityManagerInterface $entityManager,
      OperationResult $operation, Request $request): bool
    {
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid()){
            $entityManager->persist($operation);
            $entityManager->flush();
            $this->id_generated = $operation->getId();
            $this->logOperation->operationCreated($this->id_generated,$operation);
            return true;
        }
        return false;
    }

    public function getIdGenerated(): int
    {
        return $this->id_generated;
    }
}