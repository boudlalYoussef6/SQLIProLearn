<?php

declare(strict_types=1);

namespace App\File\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

final class FileUploader
{
    public function __construct(
        private readonly FileHandlerInterface $handler,
        private readonly SluggerInterface $slugger,
    ) {
    }

    public function upload(UploadedFile $attachment): string
    {
        $newFilename = $this->generateUniqueNameForAttachment($attachment);

        $this->sendContent($attachment, $newFilename);

        return $newFilename;
    }

    public function sendContent(UploadedFile $attachment, string $targetPath): void
    {
        $content = \file_get_contents($attachment->getPathname());

        $this->handler->upload($targetPath, $content);
    }

    public function removeFile($filePath): void
    {
        $this->handler->delete($filePath);
    }

    private function generateUniqueNameForAttachment(UploadedFile $attachment): string
    {
        $originalFilename = \pathinfo($attachment->getClientOriginalName(), \PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);

        return \sprintf('%s-%s.%s', $safeFilename, \uniqid(), $attachment->guessExtension());
    }
}
