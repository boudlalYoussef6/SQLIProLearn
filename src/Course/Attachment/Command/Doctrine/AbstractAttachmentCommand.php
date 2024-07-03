<?php

declare(strict_types=1);

namespace App\Course\Attachment\Command\Doctrine;

use App\Course\Attachment\Command\AttachmentCommandInterface;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractAttachmentCommand implements AttachmentCommandInterface
{
    public function __construct(protected EntityManagerInterface $manager)
    {
    }
}
