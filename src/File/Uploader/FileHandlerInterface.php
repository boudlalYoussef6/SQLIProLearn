<?php

declare(strict_types=1);

namespace App\File\Uploader;

interface FileHandlerInterface
{
    /**
     * Deletes the filename.
     */
    public function delete(string $filename): void;

    /**
     * Puts the content in the target file.
     */
    public function upload(string $filename, string $content): void;

    /**
     * Download the content of the given file.
     */
    public function download(string $filePath): string;

    /**
     * @return string[]
     */
    public function listContent(string $path = '/'): array;
}
