<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:create-ux-symlinks')]
class CreateUxSymLinksCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Fixe le répertoire racine du projet dans le container.
        $rootDir = '/var/www/html';
        $output->writeln('Répertoire racine : ' . $rootDir);

        // Le dossier cible est le dossier "assets" de symfony/ux-turbo dans vendor.
        $target = $rootDir . '/vendor/symfony/ux-turbo/assets';
        // Le lien symbolique doit être créé dans node_modules/@symfony/ux-turbo.
        $link = $rootDir . '/node_modules/@symfony/ux-turbo';

        $output->writeln('Cible : ' . $target);
        $output->writeln('Lien : ' . $link);

        // Vérifie que le dossier cible existe.
        if (!is_dir($target)) {
            $output->writeln('<error>Erreur : le dossier cible ' . $target . ' n\'existe pas.</error>');
            return Command::FAILURE;
        }

        // Crée le dossier "node_modules/@symfony" s'il n'existe pas.
        $symfonyDir = $rootDir . '/node_modules/@symfony';
        if (!is_dir($symfonyDir)) {
            mkdir($symfonyDir, 0777, true);
            $output->writeln('Création du dossier : ' . $symfonyDir);
        }

        // Si un lien ou dossier existe déjà à l'emplacement, le supprimer.
        if (file_exists($link) || is_link($link)) {
            $output->writeln('Suppression du lien ou dossier existant à : ' . $link);
            exec(sprintf('rm -rf %s', escapeshellarg($link)));
        }

        // Création du lien symbolique.
        $cmd = sprintf('ln -s %s %s', escapeshellarg($target), escapeshellarg($link));
        exec($cmd, $cmdOutput, $returnCode);
        if ($returnCode === 0) {
            $output->writeln('<info>Lien symbolique créé avec succès : ' . $link . ' -> ' . $target . '</info>');
            return Command::SUCCESS;
        } else {
            $output->writeln('<error>Erreur lors de la création du lien symbolique.</error>');
            return Command::FAILURE;
        }
    }
}
