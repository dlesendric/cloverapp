<?php

namespace AppBundle\EventListener;


use AppBundle\Filter\DeleteFilter;
use AppBundle\Filter\EnableFilter;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManagerInterface;

class BeforeRequestListener
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    protected $entityManager;

    /** @var Reader $reader */
    protected $reader;

    /**
     * BeforeRequestListener constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, Reader $reader)
    {
        $this->entityManager = $entityManager;
        $this->reader        = $reader;
    }

    public function onKernelRequest()
    {
        $filters = $this->entityManager->getFilters();
        /** @var DeleteFilter $deleteFilter */
        $deleteFilter = $filters->enable('delete_filter');
        $deleteFilter->setParameter('deleted', false);
        $deleteFilter->setAnnotationReader($this->reader);
    }
}