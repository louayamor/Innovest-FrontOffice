<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use jcobhams\NewsApi\NewsApi;
use jcobhams\NewsApi\NewsApiException;

class NewsApiController extends AbstractController
{
    private $newsApi;

    public function __construct()
    {
        $this->newsApi = new NewsApi('2e63b6208ac04af5960552080ce324e4');
    }

    /**
     * @Route("/news/top-headlines", name="news_top_headlines", methods={"GET"})
     */
    public function getTopHeadlines(Request $request): JsonResponse
    {
        try {
            $articles = $this->newsApi->getTopHeadLines(
                $request->query->get('q'),
                $request->query->get('sources'),
                $request->query->get('country'),
                $request->query->get('category'),
                $request->query->get('pageSize'),
                $request->query->get('page')
            );

            return $this->json($articles);
        } catch (NewsApiException $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/news/everything", name="news_everything", methods={"GET"})
     */
    public function getEverything(Request $request): JsonResponse
    {
        try {
            $articles = $this->newsApi->getEverything(
                $request->query->get('q'),
                $request->query->get('sources'),
                $request->query->get('domains'),
                $request->query->get('excludeDomains'),
                $request->query->get('from'),
                $request->query->get('to'),
                $request->query->get('language'),
                $request->query->get('sortBy'),
                $request->query->get('pageSize'),
                $request->query->get('page')
            );

            return $this->json($articles);
        } catch (NewsApiException $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/news/sources", name="news_sources", methods={"GET"})
     */
    public function getSources(Request $request): JsonResponse
    {
        try {
            $sources = $this->newsApi->getSources(category: 'business');

            return $this->json($sources);
        } catch (NewsApiException $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }

        return $this->render('sources.html.twig', [
            'sources' => $sources,
        ]);        
    }
}
