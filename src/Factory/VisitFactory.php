<?php

namespace App\Factory;

use App\Entity\Visit;
use App\Repository\CourseRepository;
use App\Repository\UserRepository;
use App\Repository\VisitRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Visit>
 *
 * @method        Visit|Proxy                     create(array|callable $attributes = [])
 * @method static Visit|Proxy                     createOne(array $attributes = [])
 * @method static Visit|Proxy                     find(object|array|mixed $criteria)
 * @method static Visit|Proxy                     findOrCreate(array $attributes)
 * @method static Visit|Proxy                     first(string $sortedField = 'id')
 * @method static Visit|Proxy                     last(string $sortedField = 'id')
 * @method static Visit|Proxy                     random(array $attributes = [])
 * @method static Visit|Proxy                     randomOrCreate(array $attributes = [])
 * @method static VisitRepository|RepositoryProxy repository()
 * @method static Visit[]|Proxy[]                 all()
 * @method static Visit[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Visit[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Visit[]|Proxy[]                 findBy(array $attributes)
 * @method static Visit[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Visit[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class VisitFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private readonly UserRepository $userRepository, private readonly CourseRepository $courseRepository)
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
            'lastTimeVisit' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'nbrVisit' => self::faker()->randomNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function(Visit $visit): void {
                $users = $this->userRepository->findAll();
                $courses = $this->courseRepository->findAll();

                $visit->setUser(self::faker()->randomElement($users));
                $visit->setCourse(self::faker()->randomElement($courses));

            })
        ;
    }

    protected static function getClass(): string
    {
        return Visit::class;
    }
}
