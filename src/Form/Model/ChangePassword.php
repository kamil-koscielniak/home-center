<?php
/**
 * Created by PhpStorm.
 * User: Host
 * Date: 06.10.2018
 * Time: 13:51
 */

namespace App\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{

    /**
     * @SecurityAssert\UserPassword(
     *     message="Nieprawidłowe stare hasło"
     * )
     */
    protected $oldPassword;

    /**
     * @Assert\NotBlank
     * @Assert\NotEqualTo(
     *     propertyPath="oldPassword",
     *     message="Nowe hasło nie różni się od starego"
     * )
     */
    protected $newPassword;

    /**
     * @Assert\NotBlank
     * @Assert\IdenticalTo(
     *     propertyPath="newPassword",
     *     message="Wpisane hasła różnią się"
     * )
     */
    protected $repeatedNewPassword;

    /**
     * @return mixed
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @param mixed $oldPassword
     */
    public function setOldPassword($oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword): void
    {
        $this->newPassword = $newPassword;
    }

    /**
     * @return mixed
     */
    public function getRepeatedNewPassword()
    {
        return $this->repeatedNewPassword;
    }

    /**
     * @param mixed $repeatedNewPassword
     */
    public function setRepeatedNewPassword($repeatedNewPassword): void
    {
        $this->repeatedNewPassword = $repeatedNewPassword;
    }


}
