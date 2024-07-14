<?php

declare(strict_types=1);

namespace App\Course\Attachment\Command;

use App\Entity\Course;
use App\Entity\Media;

interface AttachmentCommandInvokerInterface
{
    public function invoke(Course $course, Media $attachment, AttachmentCommandInterface $command): void;
}
