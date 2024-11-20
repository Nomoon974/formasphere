<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DeleteInactiveUsersCommand extends Command
{
    protected static $defaultName = 'app:delete-inactive-users';

    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Supprime les utilisateurs inactifs depuis plus d\'un an.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $oneYearAgo = new \DateTime();
        $oneYearAgo->modify('-1 year');

        // Récupérer les utilisateurs inactifs
        $inactiveUsers = $this->userRepository->findInactiveUsersSince($oneYearAgo);

        // Supprimer les utilisateurs
        foreach ($inactiveUsers as $user) {
            $this->entityManager->remove($user);
        }

        $this->entityManager->flush();

        $io->success(count($inactiveUsers) . ' utilisateur(s) supprimé(s).');

        return Command::SUCCESS;
    }
}
