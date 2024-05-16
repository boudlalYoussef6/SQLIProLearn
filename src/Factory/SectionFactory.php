<?php

namespace App\Factory;

use App\Entity\Section;
use App\Repository\CourseRepository;
use App\Repository\SectionRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Section>
 *
 * @method        Section|Proxy                     create(array|callable $attributes = [])
 * @method static Section|Proxy                     createOne(array $attributes = [])
 * @method static Section|Proxy                     find(object|array|mixed $criteria)
 * @method static Section|Proxy                     findOrCreate(array $attributes)
 * @method static Section|Proxy                     first(string $sortedField = 'id')
 * @method static Section|Proxy                     last(string $sortedField = 'id')
 * @method static Section|Proxy                     random(array $attributes = [])
 * @method static Section|Proxy                     randomOrCreate(array $attributes = [])
 * @method static SectionRepository|RepositoryProxy repository()
 * @method static Section[]|Proxy[]                 all()
 * @method static Section[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Section[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Section[]|Proxy[]                 findBy(array $attributes)
 * @method static Section[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Section[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class SectionFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private readonly CourseRepository $courseRepository)
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
            'description' => self::faker()->paragraph(),
            'title' => self::faker()->name(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function(Section $section): void {
                $courserepository = $this->courseRepository->findAll();
                $section->setCourse(self::faker()->unique()->randomElement($courserepository));
            })
        ;
    }

    protected static function getClass(): string
    {
        return Section::class;
    }
}
