<?php

declare(strict_types=1);

namespace App\Category\Aggregation\Elastic;

use App\Category\Aggregation\CategoryAggregationQueryInterface;
use App\Category\Query\CategoryItemInterface;
use Elastica\Aggregation\Cardinality;
use Elastica\Aggregation\Terms;
use Elastica\Query;
use FOS\ElasticaBundle\Index\IndexManager;

class ElasticCategoryAggregationQuery implements CategoryAggregationQueryInterface
{
    public function __construct(
        private readonly IndexManager $manager,
        private readonly CategoryItemInterface $itemFinder,
    ) {
    }

    public function getAggregation(): array
    {
        $query = new Query();

        $query->setSize(0);

        $categoryAggregation = new Terms('categories');
        $categoryAggregation->setField('category.id');

        $countAggregation = new Cardinality('count');
        $countAggregation->setField('_id');

        $query->addAggregation($countAggregation);
        $query->addAggregation($categoryAggregation);

        $resultSet = $this->manager->getIndex('course')->search($query);

        $aggregations = $resultSet->getAggregations();

        return \array_map(function (array $item) {
            return [
                'id' => $item['key'],
                'item' => $this->itemFinder->getItem((string) $item['key']) ?? [],
                'count' => $item['doc_count'],
            ];
        }, $aggregations['categories']['buckets']);
    }
}
