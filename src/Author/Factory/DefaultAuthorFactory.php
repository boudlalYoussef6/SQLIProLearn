<?php

declare(strict_types=1);

namespace App\Author\Factory;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

final class DefaultAuthorFactory extends AbstractAuthorFactory
{
    public function __construct(
        private readonly Security $security,
        private readonly EntityManagerInterface $manager,
    ) {
    }

    public function getAuthor(string $identifier): Author
    {
        $identifier = $this->security->getUser()?->getUserIdentifier();

        /** @var ?Author $author */
        $author = $this->manager
            ->getRepository(Author::class)
            ->findOneBy(['name' => $identifier]);

        if (null === $author) {
            $author = new Author();
            $author->setName($identifier);
        }

        return $author;
    }
}
