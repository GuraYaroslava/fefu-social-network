<?php

namespace Network\StoreBundle\Service;

use Doctrine\ORM\EntityManager;

class ImService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    public function persistThread($thread)
    {
        $this->em->persist($thread);
        $this->em->flush();
    }

    public function persistPost($post)
    {
        $this->em->persist($post);
        $this->em->flush();
    }
    //WTF
    public function persistUserThread($userThread)
    {
        $this->em->persist($userThread);
        $this->em->flush();
    }

    public function getThreadById($threadId)
    {
        return $this->em->getRepository('NetworkStoreBundle:Thread')->findOneById($threadId);
    }

}
