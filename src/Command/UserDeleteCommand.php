<?php

namespace App\Command;

use App\Controller\UserController;
use App\Service\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserDeleteCommand extends Command
{
    protected static $defaultName = 'user:delete';
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
            ->setDescription('Deletes a user from the database')
            ->addArgument('username', InputArgument::REQUIRED, 'Name of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userController->findBy(['username' => $input->getArgument('username')]);
        if (!is_null($user)){
            $this->userController->delete($user);
            $output->writeln('Success! User has been deleted!');
        }
        else{
            $output->writeln('There is no user named ' . $input->getArgument('username'));
        }
    }
}
