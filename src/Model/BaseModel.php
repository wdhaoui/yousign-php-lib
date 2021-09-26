<?php

declare(strict_types=1);

namespace Wdhaoui\Yousign\Model;

abstract class BaseModel
{
    /**
     * Model relations.
     *
     * @var array
     */
    protected $subObjects = [];

    /**
     * Get model relations.
     *
     * @return array
     */
    public function getSubObjects(): array
    {
        return $this->subObjects;
    }
}
