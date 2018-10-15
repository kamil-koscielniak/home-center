<?php

namespace App\Command;

use App\Controller\UserController;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserMakeCommand extends Command
{
    protected static $defaultName = 'user:make';
    /**
     * @var UserController
     */
    private $userController;

    public function __construct(?string $name = null, UserController $userController)
    {
        parent::__construct($name);
        $this->userController = $userController;
    }

    protected function configure()
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED,
                'The username of the user (must be unique, max length: 180)')
            ->addArgument('password', InputArgument::REQUIRED, 'password (max length: 64)')
            ->addOption('role', 'r', InputOption::VALUE_OPTIONAL, 'Role for user')
            ->setDescription('Creates a new user in database')
            ->setHelp('This command allows you to create a user...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $roles = empty($input->getOption('role')) ? [] : [$input->getOption('role')];

        $this->userController->create(
            $input->getArgument('username'),
            $input->getArgument('password'),
            $roles
        );

        $output->writeln('Success! User has been added!');
    }
}
