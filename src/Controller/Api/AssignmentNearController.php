<?php

namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Assignment;

class AssignmentNearController
{

    protected $em;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct (EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke ()
    {
        return $this->em->getRepository(Assignment::class)->getNearAssignments();
    }

}
