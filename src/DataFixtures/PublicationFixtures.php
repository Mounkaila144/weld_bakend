<?php
//
//namespace App\DataFixtures;
//
//use App\Entity\Message;
//use App\Entity\Type;
//use App\Entity\User;
//use App\Repository\ArticleRepository;
//use App\Repository\UserRepository;
//use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Doctrine\Persistence\ObjectManager;
//use Faker\Factory;
//use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
//
//
//class PublicationFixtures extends Fixture implements OrderedFixtureInterface
//{
//    public function __construct(UserRepository $userRepository,ArticleRepository $articleRepository)
//    {
//        $this->userRepository=$userRepository;
//        $this->articleRepository=$articleRepository;
//
//    }
//
//    public function load(ObjectManager $manager)
//    {
//
//        $faker = Factory::create("fr_FR");
//        for ($i = 0; $i <= 1; $i++) {
//            $id=$this->userRepository->find($faker->numberBetween(1,49));
//            $articleid=$this->articleRepository->find(1);
//            $pub = new Publication();
//            $pub
//                ->setBoost(false)
//                ->setUpdateAt(new \DateTime())
//                ->setArticle($articleid);
//            $manager->persist($pub);
//        }
//
//        $manager->flush();
//    }
//
//    public function getOrder()
//    {
//        return 5;
//    }
//}
