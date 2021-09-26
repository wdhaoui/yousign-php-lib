<?php

declare(strict_types=1);

namespace Wdhaoui\Yousign\Resource;

use Wdhaoui\Yousign\Model\Member as MemberObject;
use Wdhaoui\Yousign\Model\Procedure as ProcedureObject;

class Procedure extends AbstractResource
{
    const CREATE_PATH = 'procedures';

    public function create(ProcedureObject $procedure): ProcedureObject
    {
        $options['json'] = $procedure->toArray();

        $response = $this->request('POST', self::CREATE_PATH, $options);

        return $this->castResponseToObject($response, ProcedureObject::class);
    }

    public function update(): ProcedureObject
    {

    }

    public function get($procedureId): ProcedureObject
    {
        $response = $this->request('GET', $procedureId);

        return $this->castResponseToObject($response, ProcedureObject::class);
    }

    protected function castResponseToObject($response, $objectClassName)
    {
        $resource = parent::castResponseToObject($response, $objectClassName);
        if (is_object($resource) && \get_class($resource) === MemberObject::class) {
            $resource->setSignableLink($this->urlGenerator->generate($resource));
        }
        return $resource;
    }
}
