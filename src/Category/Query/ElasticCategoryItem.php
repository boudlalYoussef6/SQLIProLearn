<?php

declare(strict_types=1);

namespace App\Category\Query;

use Elastica\Query\Ids;
use FOS\ElasticaBundle\Index\IndexManager;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ElasticCategoryItem implements CategoryItemInterface
{
    public function __construct(private readonly IndexManager $manager, private DenormalizerInterface $normalizer)
    {
    }

    public function getItem(string $identifier): ?array
    {
        $idsQuery = new Ids();
        $idsQuery->setIds([$identifier]);

        try {
            $result = $this->manager
                ->getIndex('category')
                ->search($idsQuery)
                ->current();

            $item = $result->getData();

            return [
                'id' => $item['id'],
                'label' => $item['label'],
            ];
        } catch (\Exception) {
            return null;
        }
    }
}
