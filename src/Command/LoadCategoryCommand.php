<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:category:load',
    description: 'Loads categories from a JSON file.',
)]
class LoadCategoryCommand extends Command
{
    private int $errors = 0;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            'filename',
            InputArgument::REQUIRED,
            'The absolute fullpath of the JSON file containing the categories.',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = $input->getArgument('filename');

        if (!\file_exists($filename)) {
            $output->writeln(\sprintf('<error>File "%s" not found.</error>', $filename));

            throw new FileNotFoundException();
        }

        $jsonContent = \file_get_contents($filename);

        $categories = $this->serializer->deserialize($jsonContent, Category::class.'[]', format: 'json');

        try {
            $this->doSaveCategories($categories, $output);

            if (0 === $this->errors) {
                $output->writeln('<info>Categories have been successfully loaded.</info>');

                return Command::SUCCESS;
            }
        } catch (\Exception) {
            return Command::FAILURE;
        }

        return Command::FAILURE;
    }

    /**
     * @throws \Exception
     */
    private function doSaveCategories(array $categories, OutputInterface $output): void
    {
        foreach ($categories as $category) {
            $violations = $this->validator->validate($category);
            if (($this->errors += $violations->count()) > 0) {
                $output->writeln('<error>error: '.((string) $violations).'</error>');
                continue;
            }

            try {
                $this->entityManager->persist($category);
            } catch (\Exception $e) {
                $output->writeln('<error>Failed to deserialize category data: '.$e->getMessage().'</error>');

                throw $e;
            }
        }

        $this->entityManager->flush();
    }
}
