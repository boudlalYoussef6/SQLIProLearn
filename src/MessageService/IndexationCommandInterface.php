<?php

namespace App\MessageService;

interface IndexationCommandInterface
{
    public function execute(IndexationMessageInterface $message): void;

}