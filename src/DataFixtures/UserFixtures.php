<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher,UserRepository $userRepository)
    {
        $this->hasher = $hasher;
        $this->userRepository=$userRepository;
    }

    public function load(ObjectManager $manager)
    {

        $user = new User();
        $password = $this->hasher->hashPassword($user, '90145781');

        $user->setUsername('mounkaila')
            ->setPassword($password)
            ->setNom('Boubacar')
            ->setBoutique("boutique1")
            ->setTelephone("90145781")
            ->setDescription("description")
            ->setEmail('Mounkaila144@gmail.com')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setAdresse('fffff')
            ->setIsVerified(true);
        $manager->persist($user);

        $faker = Factory::create("fr_FR");
        for ($i = 0; $i <= 50; $i++) {
            $user = new User();
            $user->setUsername("dfghjk")
                ->setPassword($password)
                ->setNom('Boubacar')
                ->setBoutique("boutique1")
                ->setTelephone("90145781")
                ->setDescription("description")
                ->setEmail($faker->address)
                ->setAdresse('fffff')
                ->setIsVerified(true);
            $manager->persist($user);
        }
        $manager->flush();
         for ($i = 0; $i <= 20; $i++) {
            $user = new User();
            $user->setUsername("dfghjk")
                ->setPassword($password)
                ->setRoles(["ROLE_PREMIUM"])
                ->setBoutique("boutique1")
                ->setTelephone("90145781")
                ->setDescription("description")
                ->setNom('Boubacar')
                ->setEmail($faker->address)
                ->setAdresse('fffff')
                ->setIsVerified(true);
            $manager->persist($user);
        }
        $manager->flush();
         $manager->flush();
         for ($i = 0; $i <= 16; $i++) {
            $user = new User();
            $user->setUsername("dfghjk")
                ->setPassword($password)
                ->setRoles(["ROLE_GOLD"])
                ->setBoutique("boutique1")
                ->setTelephone("90145781")
                ->setDescription("description")
                ->setNom('Boubacar')
                ->setEmail($faker->address)
                ->setAdresse('fffff')
                ->setIsVerified(true);
            $manager->persist($user);
        }
        $manager->flush();

    }

    public function getOrder()
    {
        return 1;
    }
}
