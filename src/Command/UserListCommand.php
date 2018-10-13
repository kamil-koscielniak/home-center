<?php

namespace App\Command;

use App\Controller\UserController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserListCommand extends Command
{
    protected static $defaultName = 'user:list';
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
        $this->setDescription('List of users');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $users = $this->userController->list();
        if (!is_null($users)) {
            $output->writeln('Below list of users:');
            foreach ($users as $user) {
                $output->writeln($user->getUsername());
            }
        } else {
            $output->writeln('There is no users to show');
        }
    }
}
