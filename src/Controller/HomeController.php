<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Interfaces\RouteCollectorInterface;
use Twig\Environment;

class HomeController
{
    public function __construct(
        private RouteCollectorInterface $routeCollector,
        private Environment $twig,
        private EntityManagerInterface $em
    ) {}

    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            #$data = $this->twig->render('home/index.html.twig', [
            #     'trailers' => $this->fetchData(),
            # ]);
            $nowDatatime = date("d.m.Y H:i");  
            $className = __CLASS__;
            $methodName = __METHOD__;
            $info = $nowDatatime . "&nbsp" . $className . "&nbsp" . $methodName;
        } catch (\Exception $e) {
            throw new HttpBadRequestException($request, $e->getMessage(), $e);
        }

       #$response->getBody()->write($data);
       $response->getBody()->write($info);

       return $response;
    }


    protected function fetchData(): Collection
    {
        $data = $this->em->getRepository(Movie::class)
            ->findAll();

        return new ArrayCollection($data);
    }

}
