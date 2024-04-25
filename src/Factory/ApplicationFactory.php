<?php

namespace App\Factory;

use App\Entity\Application;
use App\Repository\ApplicationRepository;
use App\Repository\CourseRepository;
use App\Repository\UserRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Application>
 *
 * @method        Application|Proxy                     create(array|callable $attributes = [])
 * @method static Application|Proxy                     createOne(array $attributes = [])
 * @method static Application|Proxy                     find(object|array|mixed $criteria)
 * @method static Application|Proxy                     findOrCreate(array $attributes)
 * @method static Application|Proxy                     first(string $sortedField = 'id')
 * @method static Application|Proxy                     last(string $sortedField = 'id')
 * @method static Application|Proxy                     random(array $attributes = [])
 * @method static Application|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ApplicationRepository|RepositoryProxy repository()
 * @method static Application[]|Proxy[]                 all()
 * @method static Application[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Application[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Application[]|Proxy[]                 findBy(array $attributes)
 * @method static Application[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Application[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ApplicationFactory extends ModelFactory
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
            'dateSent' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'dateValidation' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function(Application $application): void {
                $courses = $this->courseRepository->findAll();
                $users = $this->userRepository->findAll();

                $application->setCours(self::faker()->randomElement($courses));
                $application->setUser(self::faker()->randomElement($users));

                $application->setStatus(self::faker()->randomElement(['published','rejected','pending']));
            })
        ;
    }

    protected static function getClass(): string
    {
        return Application::class;
    }
}
