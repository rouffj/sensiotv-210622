<?php

namespace App\Security\Voter;

use App\Repository\InMemoryMovieRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class MovieVoter extends Voter
{
    public const EDIT = 'MOVIE_EDIT';
    public const VIEW = 'MOVIE_VIEW';

    public function __construct(private InMemoryMovieRepository $inMemoryMovieRepository)
    {
    }

    protected function supports(string $attribute, $movie): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && array_key_exists('genres', $movie);
    }

    protected function voteOnAttribute(string $attribute, $movie, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $keywords = ['harry', 'sorcerer'];

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
            case self::VIEW:
                foreach ($keywords as $keyword) {
                    if (str_contains(strtolower($movie['title']), $keyword)) {
                        return false;
                    }
                }

                break;
        }

        return true;
    }
}
