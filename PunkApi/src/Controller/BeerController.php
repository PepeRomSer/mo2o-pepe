<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class BeerController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/", name="app_beer")
     */
    public function index(): Response
    {
        /*return new Response(
            '<html><body>Lucky number: test</body></html>'
        );*/

        
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/search_beer", methods={"POST"}, name="search_beer")
     */
    public function searchBeer(Request $request): Response
    {

        $search = $request->get('txt_food');
        $url = 'https://api.punkapi.com/v2/beers?food='.$search;

        $response = $this->client->request(
            'GET',
            $url
        );

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();

        if ($statusCode === 200) {
            $response = json_decode($content, true);
            $beers = $response;
        }

        return $this->render('beer/index.html.twig', [
            'beers' => $beers ?? [],
        ]);
    }

    /**
     * @Route("/beers", methods={"POST"}, name="get_beer")
     */
    public function getBeer(Request $request): Response
    {
        $search = $request->get('txt_id');
        $url = 'https://api.punkapi.com/v2/beers/'.$search;

        $response = $this->client->request(
            'GET',
            $url
        );

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();

        if ($statusCode === 200) {
            $response = json_decode($content, true);
            $beers = $response;
        }

        return $this->render('beer/index.html.twig', [
            'beers' => $beers ?? [],
        ]);
    }
}
