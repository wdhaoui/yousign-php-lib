<?php

declare(strict_types=1);

namespace Wdhaoui\Yousign\Utils;

use Wdhaoui\Yousign\Model\BaseModel;

class UrlGenerator
{
    private $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param BaseModel $resource
     * @return string
     *
     * Generates a string such as
     * This is the url used by customer to sign his contract on YouSign website
     */
    public function generate(BaseModel $resource): string
    {
        return $this->baseUrl . '/procedure/sign?members=' . $resource->getId();
    }
}
