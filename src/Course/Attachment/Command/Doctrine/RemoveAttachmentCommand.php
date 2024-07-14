<?php

declare(strict_types=1);

namespace App\Course\Attachment\Command\Doctrine;

use App\Entity\Course;
use App\Entity\Media;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias]
class RemoveAttachmentCommand extends AbstractAttachmentCommand
{
    public function execute(Course $course, Media $media): void
    {
        $course->removeMedia($media);
        $this->manager->remove($media);

        $this->manager->flush();
    }
}
