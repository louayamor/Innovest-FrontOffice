<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Business;
use Doctrine\ORM\EntityManagerInterface;
use jcobhams\NewsApi\NewsApi;
use jcobhams\NewsApi\NewsApiException;
use Faker\Factory as FakerFactory;

class HomeController extends AbstractController
{
    private $entityManager;
    private $newsApi;
    private $faker;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->newsApi = new NewsApi('2e63b6208ac04af5960552080ce324e4');
        $this->faker = FakerFactory::create();
    }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $latestBusinesses = $this->entityManager->getRepository(Business::class)->findBy([], ['created_at' => 'DESC'], 3);

        try {
            $articles = $this->newsApi->getTopHeadlines(
                null, 
                null, 
                'us', 
                'business', 
                10, 
                null 
            );

            foreach ($articles->articles as $article) {
                $article->randomImage = $this->generateRandomImage();
            }

            return $this->render('home/index.html.twig', [
                'articles' => $articles->articles ?? [], 
                'controller_name' => 'HomeController',
                'latestBusinesses' => $latestBusinesses,
            ]);
        } catch (NewsApiException $e) {
            
            return $this->render('home/index.html.twig', [
                'error' => $e->getMessage(), 
            ]);
        }
    }
    private function generateRandomImage()
    {
        return $this->faker->imageUrl(400, 300, 'business');
    }
}
