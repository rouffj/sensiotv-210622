<?php

namespace App\EventSubscriber;

use App\Event\MovieSearchedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoggerEventSubscriber implements EventSubscriberInterface
{
    public function onMovieSearched(MovieSearchedEvent $event): void
    {
        dump([
            'message' => 'A new search occurred',
            'movies_data' => $event->getMovies(),
            'user_data' => $event->getUser(),
        ]);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'movie_searched' => 'onMovieSearched',
        ];
    }
}
