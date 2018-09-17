<?php

namespace App\Command;

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
     * @var UserManager
     */
    private $userManager;

    public function __construct(?string $name = null, UserManager $userManager)
    {
        parent::__construct($name);
        $this->userManager = $userManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Deletes a user from the database')
            ->addArgument('username', InputArgument::REQUIRED, 'Name of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userManager->findBy(['username' => $input->getArgument('username')]);
        if (!is_null($user)){
            $this->userManager->delete($user);
            $output->writeln('Success! User has been deleted!');
        }
        else{
            $output->writeln('There is no user named ' . $input->getArgument('username'));
        }
    }
}
