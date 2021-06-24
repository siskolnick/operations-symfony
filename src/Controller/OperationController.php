<?php

namespace App\Controller;

use App\Entity\OperationResult;
use App\Repository\OperationResultRepository;
use App\Entity\OperationSum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\OperationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Flex\Unpack\Operation;

class OperationController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(OperationResultRepository $operationsRepo, Request $request, EntityManagerInterface $entityManager): Response
    {
        $operation = new OperationSum();
        $operation->setTypeId(1); // 1 = sum
        $requestOperation = new OperationRequest();
        $form = $this->createForm(OperationFormType::class, $operation);
        
        if( $requestOperation->createOperation($form,$entityManager,$operation, $request) ){

            return $this->redirectToRoute('view',['id'=>$requestOperation->getIdGenerated()]);
        }

        return $this->render('operation/index.html.twig', [
            'controller_name' => 'REST API Operaciones',
            'operation_form' => $form->createView(),
            'operations' => $operationsRepo->findAll()
        ]);
    }

    /**
     * @Route("/api/operations", name="operations")
     */
    public function operations(OperationResultRepository $operationsRepo): Response
    {
        return $this->json($operationsRepo->findAll());

    }

    /**
     * @Route("/operations/{id}", name="view")
     */
    public function view(OperationResultRepository $operationsRepo, int $id): Response
    {
        $operation = $operationsRepo->find($id);
        
        return $this->render('operation/view.html.twig', [
            'controller_name' => 'REST API Operaciones',
            'operation' => $operation
        ]);
    }
}
