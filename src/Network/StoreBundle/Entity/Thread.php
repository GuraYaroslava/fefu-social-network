<?php

namespace Network\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * thread
 *
 * @ORM\Table(name="thread")
 * @ORM\Entity(repositoryClass="Network\StoreBundle\Repository\ThreadRepository")
 */
class Thread
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="topic", type="text", nullable=true)
     */
    private $topic;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set topic
     *
     * @param string $topic
     * @return Thread
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userThreads = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }


    /**
     * @ORM\OneToMany(targetEntity="userThread", mappedBy="thread", cascade={"persist"})
     */
    protected $userThreads;
    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="thread")
     */
    protected $posts;

    /**
     * Add posts
     *
     * @param \Network\StoreBundle\Entity\Post $posts
     * @return Thread
     */
    public function addPost(\Network\StoreBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Network\StoreBundle\Entity\Post $posts
     */
    public function removePost(\Network\StoreBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Create UserThread Entity that used as link
     *
     * @param \Network\StoreBundle\Entity\User $user
     *
     * @return Thread
     */
    public function addUser(\Network\StoreBundle\Entity\User $user)
    {
        $userThread = new UserThread($user, $this);

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Network\StoreBundle\Entity\User $user
     */
    public function removeUser(\Network\StoreBundle\Entity\User $user)
    {
        foreach ($this->userThreads as $userThreads) {
            if ($userThreads->getUser() == $user) {
                $userThreads->erase();
                break;
            }
        }
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        $users = new ArrayCollection();
        foreach ($this->userThreads as $ut) {
            $users[] = $ut->getUser();
        }

        return $users;
    }

    /**
     * @param UserThread $userThread
     *
     * @return $this
     */
    public function addUserThread($userThread)
    {
        $this->userThreads[] = $userThread;

        return $this;
    }

    /**
     * increase counters of unreadposts in UserThread except $user
     *
     * @param User $user
     */
    public function incUnreadPosts($user)
    {
        foreach ($this->userThreads as $ut) {
            if ($ut->getUser()->getId() != $user->getId()) {
                $ut->incUnreadPosts();
            }
        }
    }
}
