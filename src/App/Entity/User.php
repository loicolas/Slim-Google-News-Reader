<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\UserInterface;

/**
 * Manage the User entity
 * 
 * @ORM\Entity
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="user_email", columns={"email"})}))
 *
 * @author Loïc Colas <loicolas@gmail.com>
 */
class User implements UserInterface
{
    /**
     * @var int
     * 
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    protected $email;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    protected $password;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $username;
    
    /**
     * @ORM\OneToMany(targetEntity="UserFeedPreference", mappedBy="user", cascade={"ALL"})
     */
    protected $preferences;
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->preferences = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add preference
     *
     * @param \App\Entity\UserFeedPreference $preference
     *
     * @return User
     */
    public function addPreference(\App\Entity\UserFeedPreference $preference)
    {
        $this->preferences[] = $preference;

        return $this;
    }

    /**
     * Remove preference
     *
     * @param \App\Entity\UserFeedPreference $preference
     */
    public function removePreference(\App\Entity\UserFeedPreference $preference)
    {
        $this->preferences->removeElement($preference);
    }

    /**
     * Get preferences
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreferences()
    {
        return $this->preferences;
    }
}
