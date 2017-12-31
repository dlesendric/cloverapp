<?php

namespace AppBundle\Entity\Traits;


use Doctrine\ORM\Mapping as ORM;

trait DeleteTrait
{
    /**
     * @var null|int $deleteStatus
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @return boolean|null
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean|null $deleted
     */
    public function setDeleted(bool $deleted)
    {
        $this->deleted = $deleted;
    }
}