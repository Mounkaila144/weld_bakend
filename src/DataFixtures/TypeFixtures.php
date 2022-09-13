<?php

namespace App\DataFixtures;

use App\Entity\Type;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class TypeFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create("fr_FR");
        for ($i = 0; $i <= 1; $i++) {
            $id=$this->userRepository->find($faker->numberBetween(1,49));
            $type = new Type();
            $type
                ->setNom($faker->lastName)
                ->setUser($id);
            $manager->persist($type);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
