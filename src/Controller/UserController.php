<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Model\ChangePassword;
use App\Form\PasswordResetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @param array $args
     * @return User|null|object
     */
    public function findBy(array $args)
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        return $rep->findOneBy($args);
    }

    /**
     * @param $username
     * @param $password
     * @param array $roles
     */
    public function create($username, $password, $roles = [])
    {
        if (empty($roles)){
            $roles[] = 'ROLE_USER';
        }

        $user = new User();
        $user->setUsername($username);
        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encodedPassword);
        $user->setRoles($roles);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }

    /**
     * @param User $user
     */
    public function delete(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
    }

    /**
     * @Route("/user/profile", name="user_profile")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile(Request $request)
    {
        $changePasswordModel = new ChangePassword();
        $formChangePassword = $this->createForm(PasswordResetType::class, $changePasswordModel);
        $formChangePassword->handleRequest($request);

        if ($formChangePassword->isSubmitted() && $formChangePassword->isValid()) {
            $data = $formChangePassword->getData();
            $this->changePassword($data->getNewPassword());

            $this->addFlash(
                'success',
                'Twoje hasło zostało zmienione!'
            );
        }

        return $this->render('user/profile.html.twig', [
            'form' => $formChangePassword->createView()
        ]);
    }

    /**
     * @param $newPassword
     */
    private function changePassword($newPassword)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException(
                'User not found!'
            );
        }

        $user->setPassword($this->encoder->encodePassword($user, $newPassword));
        $entityManager->persist($user);
        $entityManager->flush();
    }
}
