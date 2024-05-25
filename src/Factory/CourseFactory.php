<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Course;
use App\Repository\CategoryRepository;
use App\Repository\CourseRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Course>
 *
 * @method        Course|Proxy                     create(array|callable $attributes = [])
 * @method static Course|Proxy                     createOne(array $attributes = [])
 * @method static Course|Proxy                     find(object|array|mixed $criteria)
 * @method static Course|Proxy                     findOrCreate(array $attributes)
 * @method static Course|Proxy                     first(string $sortedField = 'id')
 * @method static Course|Proxy                     last(string $sortedField = 'id')
 * @method static Course|Proxy                     random(array $attributes = [])
 * @method static Course|Proxy                     randomOrCreate(array $attributes = [])
 * @method static CourseRepository|RepositoryProxy repository()
 * @method static Course[]|Proxy[]                 all()
 * @method static Course[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Course[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Course[]|Proxy[]                 findBy(array $attributes)
 * @method static Course[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Course[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class CourseFactory extends ModelFactory
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'description' => self::faker()->paragraph(),
            'label' => self::faker()->name(),
            'paid' => self::faker()->boolean(),
            'videoPath' => self::faker()->filePath(),
        ];
    }

    protected function initialize()
    {
    }

    protected static function getClass(): string
    {
        return Course::class;
    }
}
