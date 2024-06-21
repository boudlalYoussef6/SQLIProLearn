<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Category>
 *
 * @method        Category|Proxy                     create(array|callable $attributes = [])
 * @method static Category|Proxy                     createOne(array $attributes = [])
 * @method static Category|Proxy                     find(object|array|mixed $criteria)
 * @method static Category|Proxy                     findOrCreate(array $attributes)
 * @method static Category|Proxy                     first(string $sortedField = 'id')
 * @method static Category|Proxy                     last(string $sortedField = 'id')
 * @method static Category|Proxy                     random(array $attributes = [])
 * @method static Category|Proxy                     randomOrCreate(array $attributes = [])
 * @method static CategoryRepository|RepositoryProxy repository()
 * @method static Category[]|Proxy[]                 all()
 * @method static Category[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Category[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Category[]|Proxy[]                 findBy(array $attributes)
 * @method static Category[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Category[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class CategoryFactory extends ModelFactory
{
    private static array $topCategories = [
        'PHP',
        'Java',
        'JS',
    ];

    private static array $subCategories = [
        'PHP' => ['Symfony', 'Magento', 'Drupal'],
        'Java' => ['Spark', 'Hibernate', 'Struts'],
        'JS' => ['React', 'Angular', 'Vue'],
    ];

    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        $topCategory = self::faker()->randomElement(self::$topCategories);
        $subCategory = self::faker()->optional()->randomElement(self::$subCategories[$topCategory] ?? []);
        $label = $subCategory ?: $topCategory;

        return [
            'label' => self::faker()->unique()->regexify($label),
        ];
    }

    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function (Category $category): void {
                $categories = $this->categoryRepository->findAll();

                if (!empty($categories)) {
                    $randomCategory = self::faker()->randomElement($categories);
                } else {
                    $randomCategory = null;
                }

                if ($randomCategory instanceof Category && !in_array($category->getLabel(), self::$topCategories)) {
                    $category->setParentId($randomCategory);
                }
            });
    }

    protected static function getClass(): string
    {
        return Category::class;
    }
}
