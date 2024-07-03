<?php

declare(strict_types=1);

namespace App\Course\Attachment\Command;

use App\Entity\Course;
use App\Entity\Media;

interface AttachmentCommandInterface
{
    public function execute(Course $course, Media $media): void;
}
