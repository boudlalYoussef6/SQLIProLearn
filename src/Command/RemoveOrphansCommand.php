<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Media;
use App\File\Uploader\FileHandlerInterface;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:cloud:remove-orphans')]
class RemoveOrphansCommand extends Command
{
    public function __construct(private readonly FileHandlerInterface $handler, private readonly EntityManagerInterface $manager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $difference = $this->doComputeDifferenceBetweenDbAndRemoteContent();

        $this->doRemoveRemoveFiles($difference);

        $styler = new SymfonyStyle($input, $output);
        $styler->success(\sprintf('%d orphan files have been removed from distant server.', \count($difference)));

        return Command::SUCCESS;
    }

    private function doComputeDifferenceBetweenDbAndRemoteContent(): array
    {
        /** @var MediaRepository $repository */
        $repository = $this->manager->getRepository(Media::class);

        $remoteContent = $this->handler->listContent();

        $attachmentsInDatabase = $repository->getOrphanFiles();

        return \array_diff($remoteContent, $attachmentsInDatabase);
    }

    private function doRemoveRemoveFiles(array $removeFiles): void
    {
        \array_walk($removeFiles, fn (string $path) => $this->handler->delete($path));
    }
}
