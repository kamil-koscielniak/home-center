<?php
/**
 * Created by PhpStorm.
 * User: Host
 * Date: 13.09.2018
 * Time: 22:31
 */

namespace App\Service;

use App\Controller\UserController;
use App\Entity\User;
use App\Repository\UserRepository;

class UserManager
{
    /**
     * @var UserController
     */
    private $userController;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
    }

    public function findBy(array $args)
    {
        return $this->userController->findBy($args);
    }

    public function create($username, $password, $roles = [])
    {
        return $this->userController->create($username, $password, $roles);
    }

    public function delete(User $user)
    {
        return $this->userController->delete($user);
    }
}
