<?php

namespace App\Controller;

use App\Repository\InMemoryMovieRepository;
use App\Security\Voter\MovieVoter;
use App\Service\OmdbApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Event\MovieSearchedEvent;

class MovieController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(string $omdbToken): Response
    {
        dump($omdbToken);
        return $this->render('homepage.html');
    }

    #[Route('/movie/{id<\d+>?1}', name: 'app_movie_show')]
    //public function show(Movie $movie): Response
    public function show(int $id, InMemoryMovieRepository $inMemoryMovieRepository): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            throw new AccessDeniedException('You should have the role ADMIN to access this page');
        }
        $movie = $inMemoryMovieRepository->getMovies()[$id];
        
        $this->denyAccessUnlessGranted(MovieVoter::VIEW, $movie);

        return $this->render('movie/show.html', ['movie' => $movie]);
    }

    #[Route('/movie/search', name: 'app_movie_search')]
    public function search(Request $request, OmdbApi $omdbApi, EventDispatcherInterface $eventDispatcher): Response
    {
        
        $keyword = $request->query->get('keyword', 'Harry Potter');
        $movies = $omdbApi->requestAllBySearch($keyword);

        $eventDispatcher->dispatch(new MovieSearchedEvent($this->getUser(), $movies), 'movie_searched');

        return $this->render('movie/search.html', [
            'keyword' => $keyword,
            'movies' => $movies,
        ]);
    }

    #[Route('/movie/latest', name: 'app_movie_latest')]
    public function latest(): Response
    {
        return $this->render('movie/latest.html');
    }
}
