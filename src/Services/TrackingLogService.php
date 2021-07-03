<?php
namespace App\Services;
use Psr\Log\LoggerInterface;

class TrackingLogService
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function operationCreated($id, $operation){
        $this->logger->info('Operation created', ['id'=>$id, 'data'=>$operation]);
    }
}