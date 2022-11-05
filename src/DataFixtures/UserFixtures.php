<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public const USER_REFERENCE = 'user_id';
    
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();

        // for ($i = 0; $i < 6; $i++) {
            $user = new User();
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'the_new_password'
            ));
            $user->setEmail($faker->email());
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());

            $this->addReference(self::USER_REFERENCE, $user);
            $manager->persist($user);
        // }
        $manager->flush();
    }
    public static function getGroups(): array
    {
        return ['group1', 'group2'];
    }
}

//  link show who i use two class fixtures ---> https://blog.gary-houbre.fr/developpement/symfony/symfony-comment-mettre-en-place-des-fixtures
