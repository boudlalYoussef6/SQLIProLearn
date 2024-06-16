<?php

declare(strict_types=1);

namespace App\File\Uploader;

use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\StorageAttributes;
use Symfony\Component\DependencyInjection\Attribute\Target;

final class CloudFileHandler implements FileHandlerInterface
{
    private FilesystemOperator $storage;

    public function __construct(#[Target('awsStorage')] FilesystemOperator $storage)
    {
        $this->storage = $storage;
    }

    public function delete(string $filename): void
    {
        try {
            $this->storage->delete($filename);
        } catch (FilesystemException $e) {
        }
    }

    public function upload(string $filename, string $content): void
    {
        try {
            $this->storage->write($filename, $content);
        } catch (FilesystemException $e) {
        }
    }

    public function download(string $filePath): string
    {
        try {
            return $this->storage->read($filePath);
        } catch (FilesystemException $e) {
            return '';
        }
    }

    /**
     * @throws FilesystemException
     */
    public function listContent(string $path = '/'): array
    {
        return $this->storage
            ->listContents($path)
            ->filter(fn (StorageAttributes $attr) => $attr->isFile())
            ->map(fn (StorageAttributes $attr) => $attr->path())
            ->toArray();
    }
}
