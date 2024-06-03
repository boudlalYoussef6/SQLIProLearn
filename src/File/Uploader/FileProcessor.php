<?php

declare(strict_types=1);

namespace App\File\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

final class FileProcessor
{
    public function __construct(private readonly FileHandlerInterface $handler)
    {
    }

    public function processFile(UploadedFile $file): void
    {
        $filename = $file->getClientOriginalName();
        $content = \file_get_contents($file->getPathname());

        $this->handler->upload($filename, $content);
    }

    public function removeFile($filePath): void
    {
        $this->handler->delete($filePath);
    }
}
