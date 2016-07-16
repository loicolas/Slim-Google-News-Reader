<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Describe the UserFeedPreference entity
 *
 * @ORM\Entity
 * @ORM\Table(name="user_feed_preference")}))
 *
 * @author Loïc Colas <loicolas@gmail.com>
 */
class UserFeedPreference
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User", inversedBy="preferences")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    /**
     * @var string
     * 
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    protected $feed;
    
    /**
     * @var bool
     * 
     * @ORM\Column(type="boolean")
     */
    protected $active;
    

    /**
     * Set feed
     *
     * @param string $feed
     *
     * @return UserFeedPreference
     */
    public function setFeed($feed)
    {
        $this->feed = $feed;

        return $this;
    }

    /**
     * Get feed
     *
     * @return string
     */
    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return UserFeedPreference
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     *
     * @return UserFeedPreference
     */
    public function setUser(\App\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
