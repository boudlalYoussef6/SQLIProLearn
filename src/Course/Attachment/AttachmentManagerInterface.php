<?php

declare(strict_types=1);

namespace App\Course\Attachment;

use App\Entity\Course;

interface AttachmentManagerInterface
{
    public function save(Course $course): Course;
}
