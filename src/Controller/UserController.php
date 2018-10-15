<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Avatar;
use App\Form\Model\ChangePassword;
use App\Form\PasswordReset;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    const AVATAR_PATH = 'images/avatars/';
    const AVATAR_NAME_PREFIX = 'avt';
    const AVATAR_DEFAULT = 'avt-default.png';

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
     * @return User[]|object[]
     */
    public function list()
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        return $rep->findAll();
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
        if (empty($roles)) {
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
        $formChangePassword = $this->createForm(PasswordReset::class, $changePasswordModel);
        $formChangeAvatar = $this->createForm(Avatar::class);
        $formChangePassword->handleRequest($request);
        $formChangeAvatar->handleRequest($request);

        if ($formChangePassword->isSubmitted() && $formChangePassword->isValid()) {
            $data = $formChangePassword->getData();
            $this->changePassword($data->getNewPassword());

            $this->addFlash(
                'success',
                'Twoje hasło zostało zmienione!'
            );
        }

        if ($formChangeAvatar->isSubmitted() && $formChangeAvatar->isValid()) {
            $data = $formChangeAvatar->getData();
            /** @var UploadedFile $file */
            $file = $data['avatar'];

            if (!empty($file)){
                try {
                    $file->move(
                        self::AVATAR_PATH,
                        self::createAvatarName($this->getUser()->getId())
                    );
                } catch (FileException $e) {
                    $this->addFlash(
                        'error',
                        'Wystąpiły problemy!'
                    );
                }

                $this->addFlash(
                    'success',
                    'Avatar został zmieniony!'
                );
            }
        }

        return $this->render('user/profile.html.twig', [
            'formChangePassword' => $formChangePassword->createView(),
            'formChangeAvatar' => $formChangeAvatar->createView(),
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

    /**
     * @param string $userID
     * @return bool
     */
    public static function isAvatarExists(string $userID): bool
    {
        return file_exists(self::AVATAR_PATH . self::createAvatarName($userID));
    }

    /**
     * @param string $userID
     * @return string
     */
    public static function getAvatarFile(string $userID): string
    {
        if (self::isAvatarExists($userID)) {
            $avatar = self::AVATAR_PATH . self::createAvatarName($userID);
        } else {
            $avatar = 'build/' . self::AVATAR_PATH . self::AVATAR_DEFAULT;
        }
        
        return $avatar;
    }

    /**
     * @param int $userID
     * @return string
     */
    public static function createAvatarName(int $userID): string
    {
        return self::AVATAR_NAME_PREFIX . $userID.'.jpg';
    }
}
