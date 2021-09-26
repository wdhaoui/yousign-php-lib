<?php

declare(strict_types=1);

namespace Wdhaoui\Yousign\Resource;

use Wdhaoui\Yousign\Model\File as FileObject;

class File extends AbstractResource
{
    const CREATE_PATH = 'files';
    const DOWNLOAD_PATH = '/download';

    public function create(FileObject $file): FileObject
    {
        $options['json'] = $file->toArray();

        $response = $this->request('POST', self::CREATE_PATH, $options);

        return $this->castResponseToObject($response, FileObject::class);
    }

    public function download(string $fileId): string
    {
        $response = $this->request('GET', $fileId . self::DOWNLOAD_PATH);

        return $response->getBody()->getContents();
    }
}
