<?php

declare(strict_types=1);

namespace App\Contracts;

interface PaginableInterface
{
    public function getResult(): array;

    public function getTotalPages(): int;

    public function getCount(): int;
}
