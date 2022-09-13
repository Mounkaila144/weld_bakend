<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\MessageRepository;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(ArticleRepository $articleRepository,UserRepository $userRepository, MessageRepository $messageRepository,
                          TypeRepository $typeRepository): Response
    {
        $article=$articleRepository->findAll();
        $countArticle = $this->Count($article);
        $type=$typeRepository->findAll();
        $countType = $this->Count($type);
        $user = $userRepository->findAll();
        $countUser = $this->Count($user);
        $pub = $articleRepository->findBy(["publier"=>true]);
        $countPub = $this->Count($pub);
        $premium = $userRepository->findByRole("ROLE_PREMIUM");
        $countPremium = $this->Count($premium);
        $boost = $articleRepository->findBy(["boost"=>true]);
        $countBoost =Count($boost);
        $gold = $userRepository->findByRole("ROLE_GOLD");
        $countGold = $this->Count($gold);

        return $this->render('home/index.html.twig',['countUser'=>count($countUser),
            'countArticle'=>count($countArticle), 'countType'=>count($countType),
            'countPub'=>count($countPub),'countPremium'=>count($countPremium),
            'countGold'=>count($countGold),'countBoost'=>$countBoost,]);
    }

    #[Route('/statistique', name: 'app_statistique', methods: ['GET'])]
    public function stat(): Response
    {
        return $this->render('home/statistique.html.twig', [
        ]);
    }



    /**
     * @param array $pub
     * @return array
     */
    protected function Count(array $pub): array
    {
        $countPub = [];
        foreach ($pub as $as) {
            $countPub[] = $as->getId();
        }
        return $countPub;
    }
}
