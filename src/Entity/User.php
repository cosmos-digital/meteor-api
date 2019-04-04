<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="token", message="Token already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 * @ORM\Table(schema="users")
 */
class User implements UserInterface, IEntity
{
    /**
     *
     * @ORM\Id
     * @ORM\Column(name="uid", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $uid;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(max=4096, min=8)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     * @Assert\Length(max=4096, min=8)
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="These passwords do not match. Try again.")
     */
    public $password_repeat;

    /**
     * @ORM\Column(type="string", length=64)
     */
    public $token;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
    public function getId(): ?string
    {
        return $this->uid;
    }
    /**
     * Returns the roles granted to the user.
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {

    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }
}
