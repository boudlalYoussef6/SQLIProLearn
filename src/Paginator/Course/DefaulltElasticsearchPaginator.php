<?php

declare(strict_types=1);

namespace App\Paginator\Course;

use App\Course\Query\Decorator\GetAllItemsDecorator;
use App\Course\Query\ItemsQueryInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\RequestStack;

class DefaulltElasticsearchPaginator extends AbstractCoursePaginator
{
    public function __construct(
        #[Autowire(service: GetAllItemsDecorator::class)]
        private ItemsQueryInterface $itemsFinder,
        private RequestStack $requestStack,
    ) {
    }

    public function getResult(): array
    {
        $request = $this->requestStack->getCurrentRequest();

        return $this->itemsFinder->findItems($request->query->getInt('page', 1));
    }

    public function getTotalPages(): int
    {
        return $this->itemsFinder->getTotalPages();
    }
}
