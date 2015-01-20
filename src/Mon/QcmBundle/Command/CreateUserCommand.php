<?php

namespace Mon\QcmBundle\Command;

use Mon\QcmBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('qcm:user:create')
            ->setDescription('Commande pour créer un utilisateur')
            ->addArgument('email', InputArgument::REQUIRED, 'email de l\'utilisateur', null)
            ->addArgument('password', InputArgument::REQUIRED, 'mot de passe de l\'utilisateur', null)
            ->addArgument('name', InputArgument::REQUIRED, 'nom de l\'utilisateur', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $name = $input->getArgument('name');

        $output->writeln(sprintf('<bg=yellow;fg=black;options=bold>Création de l\'utilisateur</bg=yellow;fg=black;options=bold> %s', $email));

        $user = new User();

        $doctrine = $this->getContainer()->get('doctrine');
        $encoderFactory = $this->getContainer()->get('security.encoder_factory');
        $encoder = $encoderFactory->getEncoder($user);
    }

}