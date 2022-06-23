<?php

namespace App\Command;

use App\Service\OmdbApi;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'omdb:search',
    description: 'Add a short description for your command',
)]
class OmdbSearchCommand extends Command
{
    private OmdbApi $omdbApi;

    public function __construct(OmdbApi $omdbApi)
    {
        $this->omdbApi = $omdbApi;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::OPTIONAL, 'Movie title you are looking for.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (!$title = $input->getArgument('title')) {
            $title = $io->ask('Which movie you are looking for?', 'Sky');
        }

        $movies = $this->omdbApi->requestAllBySearch($title);
        $io->success(sprintf('%d movies found for your search: "%s"', $movies['totalResults'], $title));
        //dump($movies);

        $rows = [];
        $progress = $io->createProgressBar(count($movies['Search']));
        foreach ($movies['Search'] as $movie) {
            usleep(100000);
            $progress->advance();
            $rows[] = [
                $movie['Title'],
                $movie['Year'],
                'https://www.imdb.com/title/' . $movie['imdbID'],
            ];
        }
        $progress->clear();

        $io->table(['TITLE', 'YEAR', 'URL'], $rows);
        /*
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
        */

        return 0;
    }
}
