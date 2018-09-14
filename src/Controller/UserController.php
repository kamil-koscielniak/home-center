<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{

    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    public function findBy(array $args)
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        return $rep->findOneBy($args);
    }

    public function create($username, $password, $roles = [])
    {
        $user = new User();
        $user->setUsername($username);
        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encodedPassword);
        $user->setRoles($roles);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }

    public function delete(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
    }
}
