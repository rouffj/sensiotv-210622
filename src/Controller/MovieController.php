<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('homepage.html');
    }

    #[Route('/movie/{id<\d+>?1}', name: 'app_movie_show')]
    public function show(int $id): Response
    {
        return $this->render('movie/show.html', ['movie' => $this->getMovies()[$id]]);
    }

    #[Route('/movie/search', name: 'app_movie_search')]
    public function search(): Response
    {
        return $this->render('movie/search.html', [
            'controller_name' => 'MovieController',
        ]);
    }

    #[Route('/movie/latest', name: 'app_movie_latest')]
    public function latest(): Response
    {
        return $this->render('movie/latest.html');
    }

    private function getMovies(): array
    {
        return [
            1 => [
                'title' => 'Avengers: Endgame',
                'image' => 'https://m.media-amazon.com/images/M/MV5BMTc5MDE2ODcwNV5BMl5BanBnXkFtZTgwMzI2NzQ2NzM@._V1_SX300.jpg',
                'release_date' => new \DateTime('2015-01-01'),
                'genres' => ['action', 'aventure'], 
            ],
            2 => [
                'title' => 'Harry Potter and the Sorcerer\'s Stone',
                'image' => 'https://m.media-amazon.com/images/M/MV5BNjQ3NWNlNmQtMTE5ZS00MDdmLTlkZjUtZTBlM2UxMGFiMTU3XkEyXkFqcGdeQXVyNjUwNzk3NDc@._V1_SX300.jpg',
                'release_date' => new \DateTime('2010-01-01'),
                'genres' => ['action', 'aventure'], 
            ]
        ];
    }
}
