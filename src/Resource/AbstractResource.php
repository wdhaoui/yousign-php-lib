<?php

declare(strict_types=1);

namespace Wdhaoui\Yousign\Resource;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Wdhaoui\Yousign\Exception\SignatureException;
use Wdhaoui\Yousign\Utils\UrlGenerator;

abstract class AbstractResource
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

    public function request($method, $uri, array $options = [])
    {
        try {
            $response = $this->client->request($method, $uri, $options);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
        }

        if (200 !== $response->getStatusCode() && 201 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $response;
    }

    protected function handleErrors(ResponseInterface $response)
    {

        $content = \json_decode($response->getBody()->getContents(), true);

        switch ($response->getStatusCode()) {
            case 400:
                throw new SignatureException(
                    $response->getStatusCode(),
                    $content['title'] ?? null,
                    null,
                    $content['violations'] ?? [['message' => $content['detail']]]
                );
                break;
            case 401:
                throw new SignatureException($response->getStatusCode(),
                    $content['error_description'] ?? 'Invalid API key');
                break;
            case 403:
                throw new SignatureException($response->getStatusCode(), 'Insufficient Privileges');
                break;
            case 404:
                throw new SignatureException($response->getStatusCode(), 'Not found');
                break;
            case 405:
                throw new SignatureException($response->getStatusCode(), 'Method Not Allowed');
                break;
            default:
                throw new SignatureException($response->getStatusCode(), 'Unknown error');
                break;
        }
    }

    protected function castResponseToObject($response, $objectClassName)
    {
        if (\is_array($response)) {
            if ($this->isAssociativeArray($response)) {
                $response = \json_decode(\json_encode($response, false));
            } else {
                $list = [];
                foreach ($response as $responseObject) {
                    $list[] = $this->castResponseToObject($responseObject, $objectClassName);
                }

                return $list;
            }
        }
        if (!\class_exists($objectClassName)) {
            throw new \Exception(\sprintf('Class "%s" does not exists.', $objectClassName));
        }

        if ($response instanceof ResponseInterface) {
            $response = \json_decode($response->getBody()->getContents());
        }

        $object = new $objectClassName();
        $responseReflection = new \ReflectionObject($response);
        $objectReflection = new \ReflectionClass($objectClassName);
        $responseProperties = $responseReflection->getProperties();
        $subObjects = $object->getSubObjects();
        foreach ($responseProperties as $responseProperty) {
            $responseProperty->setAccessible(true);
            $name = $responseProperty->getName();
            $value = $responseProperty->getValue($response);
            if ($objectReflection->hasProperty($name)) {
                $objectProperty = $objectReflection->getProperty($name);
                $objectProperty->setAccessible(true);
                // is sub object?
                if (isset($subObjects[$name])) {
                    if (null === $value) {
                        $object = null;
                    } else {
                        $value = $this->castResponseToObject($value, $subObjects[$name]);
                    }
                    $objectProperty->setValue($object, $value);
                } elseif (is_object($value)) { // is array
                    $value = json_decode(json_encode($value), true);
                    $objectProperty->setValue($object, $value);
                } else {
                    $objectProperty->setValue($object, $value);
                }
            }
        }

        return $object;
    }

    private function isAssociativeArray($array)
    {
        return \array_keys($array) !== \range(0, \count($array) - 1);
    }
}
