<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Type;
use App\Entity\User;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class ArticleFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct(UserRepository $userRepository,TypeRepository $typeRepository)
    {
        $this->userRepository=$userRepository;
        $this->typeRepository=$typeRepository;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create("fr_FR");
        for ($i = 0; $i <= 1; $i++) {
            $id=$this->userRepository->find($faker->numberBetween(1,49));
            $typeid=$this->typeRepository->find(1);
            $article = new Article();
            $article
                ->setUser($id)
                ->setNom($faker->lastName)
               ->setStock($faker->numberBetween(1,88))
                ->setDescription($faker->text)
                ->setType($typeid)
                ->setPrix($faker->numberBetween(300,9000));
            $manager->persist($article);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}

