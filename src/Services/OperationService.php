<?php
namespace App\Services;

use App\Entity\OperationResult;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;

class OperationService
{
    protected $id_generated = 0;
    public function createOperation(FormInterface $form, EntityManagerInterface $entityManager,
      OperationResult $operation, Request $request): bool
    {
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid()){
            $entityManager->persist($operation);
            $entityManager->flush();
            $this->id_generated = $operation->getId();
            return true;
        }
        return false;
    }

    public function getIdGenerated(): int
    {
        return $this->id_generated;
    }
}