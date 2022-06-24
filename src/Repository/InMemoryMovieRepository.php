<?php

namespace App\Repository;

class InMemoryMovieRepository
{
    public function getMovies(): array
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