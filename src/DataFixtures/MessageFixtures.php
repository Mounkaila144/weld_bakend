<?php

namespace App\DataFixtures;

use App\Entity\Message;
use App\Entity\Type;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class MessageFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create("fr_FR");
        for ($i = 0; $i <= 3; $i++) {
            $id=$this->userRepository->find($faker->numberBetween(1,49));
            $me=$this->userRepository->find(1);
            $message = new Message();
            $message
                ->setUser($me)
                ->setUpdateAt(new \DateTime())
                ->setVue(true)
                ->setContenu($faker->text)
                ->setDestinateur($id);
            $manager->persist($message);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
