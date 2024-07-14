<?php

declare(strict_types=1);

namespace App\Course\Catalog;

use App\Contracts\PaginableInterface;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\MatchAll;
use Elastica\Query\Term;
use Elastica\ResultSet;
use FOS\ElasticaBundle\Index\IndexManager;

class DefaultCatalogManager implements CatalogManagerInterface
{
    private const ITEMS_PER_PAGE = 6;

    public function __construct(private readonly IndexManager $manager)
    {
    }

    public function populate(int $page): PaginableInterface
    {
        $query = new Query();

        $offset = $page - 1;

        $query->setFrom($offset * self::ITEMS_PER_PAGE)
            ->setQuery(new MatchAll())
            ->setSize(self::ITEMS_PER_PAGE)
            ->addSort('_score')
            ->addSort(['id' => 'desc']);

        $result = $this->manager
            ->getIndex('course')
            ->search($query);

        return $this->doCreatePaginableResult($result, self::ITEMS_PER_PAGE);
    }

    public function filter(int $page, string $categoryIdentifier): PaginableInterface
    {
        $query = new Query();

        $query->setQuery(
            (new BoolQuery())
                ->addMust(
                    new Term(['category.id' => $categoryIdentifier])
                )
        );

        $result = $this->manager
            ->getIndex('course')
            ->search($query);

        return $this->doCreatePaginableResult($result, self::ITEMS_PER_PAGE);
    }

    private function doCreatePaginableResult(ResultSet $result, int $itemsPerPage = 0): PaginableInterface
    {
        return new class($result, self::ITEMS_PER_PAGE) implements PaginableInterface {
            private ResultSet $result;
            private int $totalPages;
            private int $count;

            public function __construct(ResultSet $result, int $maxPerPage)
            {
                $this->result = $result;
                $this->totalPages = $maxPerPage <= 1 ? 1 : (int) \ceil(($this->count = $result->getTotalHits()) / $maxPerPage);
            }

            public function getResult(): array
            {
                $output = [];

                foreach ($this->result as $item) {
                    $output[] = $item->getHit()['_source'];
                }

                return $output;
            }

            public function getTotalPages(): int
            {
                return $this->totalPages;
            }

            public function getCount(): int
            {
                return $this->count;
            }
        };
    }
}
