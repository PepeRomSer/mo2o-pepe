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
        if($search == "")
        {
            return $this->render('beer/index.html.twig', [
                'beers' => [],
                'msg' => "Campo FOOD vacio. Introduzca termino a buscar."
            ]);
        }
        else
        {
            $beers = $this->callApi('beers?food='.$search);
            return $this->render('beer/index.html.twig', [
                'beers' => $beers ?? [],
                'msg' => ""
            ]);
        }
        
    }

    /**
     * @Route("/beers", methods={"POST"}, name="get_beer")
     */
    public function getBeer(Request $request): Response
    {
        $search = $request->get('txt_id');
        $beers = $this->callApi('beers/'.$search);

        return $this->render('beer/index.html.twig', [
            'beers' => $beers ?? [],
            'msg' => ""
        ]);
    }



    public function callApi($urlParam)
    {

        $urlBase = 'https://api.punkapi.com/v2/';
        $url = $urlBase."".$urlParam;

        $response = $this->client->request(
            'GET',
            $url
        );

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();

        if ($statusCode === 200) {
            $response = json_decode($content, true);
        }

        return $response;

    }
}
