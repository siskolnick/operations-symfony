<?php

namespace App\Controller;

use App\Repository\OperationResultRepository;
use App\Entity\OperationSum;
use App\Services\OperationService;
use App\Services\OperationRESTClientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\OperationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;

class OperationController extends AbstractController
{
    /**
     * @Route("/operations/index", name="homepage")
     */
    public function index(OperationResultRepository $operationsRepo, Request $request, EntityManagerInterface $entityManager, OperationService $operationService): Response
    {
        $operation = new OperationSum();
        $operation->setTypeId(1); // 1 = sum
        $form = $this->createForm(OperationFormType::class, $operation);
        
        if( $operationService->createOperation($form,$entityManager,$operation, $request) ){

            return $this->redirectToRoute('view',['id'=>$operationService->getIdGenerated()]);
        }

        return $this->render('operation/index.html.twig', [
            'controller_name' => 'REST API Operaciones',
            'operation_form' => $form->createView(),
            'operations' => $operationsRepo->findAll()
        ]);
    }

    /**
     * @Route("/operations/node/index", name="nodeindex")
     */
    public function nodeIndex(OperationRESTClientService $restClient, Request $request): Response
    {
        $operation = new OperationSum();
        $operation->setTypeId(1); // 1 = sum
        $form = $this->createForm(OperationFormType::class, $operation);
        $form->handleRequest($request);
        
        if( $restClient->createOperation($form) ){

            return $this->redirectToRoute('view',['id'=>$restClient->getIdGenerated()]);
        }

        //dd($restClient->getOperations());
        return $this->render('operation/index.html.twig', [
            'controller_name' => 'REST API Operaciones',
            'operation_form' => $form->createView(),
            'operations' => $restClient->getOperations(),
        ]);
    }

    /**
     * @Route("/api/operations", name="operations")
     */
    public function operations(OperationResultRepository $operationsRepo): Response
    {
        $data = $this->get('serializer')->serialize($operationsRepo->findAll(), 'json');

        return new Response($data);

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
