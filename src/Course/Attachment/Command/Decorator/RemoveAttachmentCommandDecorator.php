<?php

declare(strict_types=1);

namespace App\Course\Attachment\Command\Decorator;

use App\Course\Attachment\Command\AttachmentCommandInterface;
use App\Course\Attachment\Command\Doctrine\RemoveAttachmentCommand;
use App\Entity\Course;
use App\Entity\Media;
use App\File\Uploader\FileHandlerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;

#[AsDecorator(decorates: RemoveAttachmentCommand::class)]
class RemoveAttachmentCommandDecorator implements AttachmentCommandInterface
{
    /** @var RemoveAttachmentCommand */
    private object $inner;
    private FileHandlerInterface $fileHandler;

    public function __construct(#[AutowireDecorated] object $inner, FileHandlerInterface $fileHandler)
    {
        $this->inner = $inner;
        $this->fileHandler = $fileHandler;
    }

    public function execute(Course $course, Media $media): void
    {
        $this->inner->execute($course, $media);

        $this->fileHandler->delete($media->getFileName());
    }
}
