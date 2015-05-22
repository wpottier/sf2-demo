<?php

namespace Mon\QcmBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateAdminCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('qcm:admin:create')
            ->setDescription('Commande pour créer un admin.')
            ->addOption('email', '', InputOption::VALUE_OPTIONAL, 'email de l\'admin')
            ->addOption('password', '', InputOption::VALUE_OPTIONAL, 'password de l\'admin')
            ->addOption('name', '', InputOption::VALUE_OPTIONAL, 'name de l\'admin');
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        /** @var \Symfony\Component\Console\Helper\QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        $questionEmail = new Question('Email de l\'utilisateur ? ');
        $questionEmail->setValidator(function ($answer) {
            if (filter_var($answer, FILTER_VALIDATE_EMAIL) === false) {
                throw new \RuntimeException('Email invalide.');
            }

            return $answer;
        });
        $email = $questionHelper->ask($input, $output, $questionEmail);
        $input->setOption('email', $email);

        $questionPassword = new Question('Mot de passe de l\'utilisateur ? ');
        $questionPassword->setHidden(true);
        $questionPassword->setValidator(function ($answer) {
            if (strlen($answer) < 3) {
                throw new \RuntimeException('Minimum 3 caractères.');
            }

            return $answer;
        });
        $password = $questionHelper->ask($input, $output, $questionPassword);
        $input->setOption('password', $password);

        $questionName = new Question('Nom de l\'utilisateur ? ');
        $questionName->setValidator(function ($answer) {
            if (strlen($answer) < 3) {
                throw new \RuntimeException('Minimum 3 caractères.');
            }

            return $answer;
        });
        $name = $questionHelper->ask($input, $output, $questionName);
        $input->setOption('name', $name);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<bg=yellow;fg=black;options=bold>Création de l\'administrateur</bg=yellow;fg=black;options=bold>');

        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $name = $input->getArgument('name');

        $user = new \Mon\QcmBundle\Entity\User();

        $user
            ->setName($name)
            ->setEmail($email)
            ->setRoles(['ROLE_ADMIN', 'ROLE_FOO'])
            ;

        $encoder = $this->getContainer()->get('security.encoder_factory')->getEncoder($user);
        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        $this->getContainer()->get('mon_qcm.mailer.user')->sendWelcome($user);

        $output->writeln('<info>Fait !</info>');
    }

}