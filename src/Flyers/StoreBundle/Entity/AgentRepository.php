<?php

namespace Flyers\StoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AgentRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('created_at' => 'DESC'));
    }
}