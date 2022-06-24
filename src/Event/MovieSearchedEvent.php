<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\User;

class MovieSearchedEvent extends Event
{
    public function __construct(private User $user, private array $movies)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getMovies()
    {
        return $this->movies;
    }
}