<?php

declare(strict_types=1);

namespace App\Factory\Course;

use App\Course\Handler\CourseHandlerInterface;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Course;

abstract class AbstractCourseFactory
{
    /**
     * @param string $rawData A json/Xml content
     */
    abstract public function buildCourseInstance(string $rawData): Course;

    /**
     * @param string $rawData A json/Xml content
     */
    abstract public function buildAutorInstance(string $rawData): Author;

    public function addCourse(string $rawData, Category $category, CourseHandlerInterface $handler): Course
    {
        $author = $this->buildAutorInstance($rawData);

        $course = $this->buildCourseInstance($rawData)
            ->setAuthor($author)
            ->setCategory($category);

        $handler->add($course);

        return $course;
    }
}
