<?php

declare(strict_types=1);

namespace Wdhaoui\Yousign;

use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Wdhaoui\Yousign\Model\File;
use Wdhaoui\Yousign\Model\Procedure;
use Wdhaoui\Yousign\Utils\UrlGenerator;

class Signature
{
    protected $client;
    protected $urlGenerator;

    protected $logger;

    public function __construct(ClientInterface $client, UrlGenerator $urlGenerator, LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->urlGenerator = $urlGenerator;

        if (null === $logger) {
            $logger = new NullLogger();
        }

        $this->logger = $logger;
    }

    /**
     * Create Procedure: Basic mode.
     *
     * @see https://dev.yousign.com/
     *
     * @param Procedure $procedure
     * @param File      $file
     *
     * @return Procedure
     */
    public function initProcedure(Procedure $procedure, File $file): Procedure
    {
        // Step 1 - Upload the files
        $file = $this->createFile($file);
        foreach ($procedure->getMembers() as $member) {
            foreach ($member->getFileObjects() as $fileObject) {
                $fileObject->setFile($file);
            }
        }

        //Step 2 - Create the procedure

        return $this->createProcedure($procedure);
    }

    public function createProcedure(Procedure $procedure): Procedure
    {
        $resource = $this->resource(ResourceType::PROCEDURE);

        return $resource->create($procedure);
    }

    public function createFile(File $file): File
    {
        $fileResource = $this->resource(ResourceType::FILE);

        return $fileResource->create($file);
    }

    public function getProcedure(string $procedureId): Procedure
    {
        $resource = $this->resource(ResourceType::PROCEDURE);

        return $resource->get($procedureId);
    }

    public function downloadFile(string $fileId): string
    {
        $resource = $this->resource(ResourceType::FILE);

        return $resource->download($fileId);
    }

    private function resource($name)
    {
        $resource = new $name($this->client, $this->urlGenerator, $this->logger);

        return $resource;
    }
}
