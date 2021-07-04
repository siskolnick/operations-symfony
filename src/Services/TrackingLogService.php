<?php
namespace App\Services;
use Psr\Log\LoggerInterface;

class TrackingLogService
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var MailService
     */
    private $mailService;

    public function __construct(LoggerInterface $logger, MailService $mailService)
    {
        $this->logger = $logger;
        $this->mailService = $mailService;
    }

    public function operationCreated($id, $operation){
        $this->logger->info('Operation created', ['id'=>$id, 'data'=>$operation]);
        $this->mailService->sendEmailOperationCreated($operation);
    }
}