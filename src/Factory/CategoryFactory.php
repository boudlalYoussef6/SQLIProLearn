<?php

namespace App\Factory;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\CourseRepository;
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
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private readonly CourseRepository $categoryRepository)
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'label' => self::faker()->text(30),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
        ->afterInstantiate(function(Category $category): void {
            $categories = $this->categoryRepository->findAll();

            // Vérifiez si la liste des catégories n'est pas vide
            if (!empty($categories)) {
                // Sélectionnez un élément aléatoire de la liste
                $randomCategory = self::faker()->randomElement($categories);
            } else {
                // Si la liste des catégories est vide, attribuez null à parentId
                $randomCategory = null;
            }

            // Assurez-vous que $randomCategory est une instance de Category avant de l'assigner
            if ($randomCategory instanceof Category) {
                $category->setParentId($randomCategory);
            }
        });
    }

    protected static function getClass(): string
    {
        return Category::class;
    }
}
