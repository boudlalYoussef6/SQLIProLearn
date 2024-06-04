<?php

declare(strict_types=1);

namespace App\Author\Factory;

use App\Entity\Author;
use App\Entity\Course;

abstract class AbstractAuthorFactory
{
    abstract public function getAuthor(string $identifier): Author;

    public function affectAuthorToCourse(string $authorIdentifier, Course $course): void
    {
        $author = $this->getAuthor($authorIdentifier);

        $course->setAuthor($author);
    }
}
