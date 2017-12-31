<?php

namespace AppBundle\EventListener;


use AppBundle\Annotation\FilterDeleted;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ControllerFilterDeletedListener
{
    /** @var Reader */
    private $reader;

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    const DELETE_FILTER = 'delete_filter';

    /**
     * @param Reader $reader
     */
    public function __construct(Reader $reader, EntityManagerInterface $entityManager)
    {
        $this->reader        = $reader;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if (!is_array($controllers = $event->getController())) {
            return;
        }

        list($controller, $methodName) = $controllers;

        $reflectionClass = new \ReflectionClass($controller);
        /** @var FilterDeleted $classAnnotation */
        $classAnnotation = $this->reader
            ->getClassAnnotation($reflectionClass, FilterDeleted::class);

        $reflectionObject = new \ReflectionObject($controller);
        $reflectionMethod = $reflectionObject->getMethod($methodName);
        /** @var FilterDeleted $methodAnnotation */
        $methodAnnotation = $this->reader
            ->getMethodAnnotation($reflectionMethod, FilterDeleted::class);

        if (!($classAnnotation || $methodAnnotation)) {
            return;
        }

        $filters = $this->entityManager->getFilters();

        $enabled = $methodAnnotation ? $methodAnnotation->enabled : $classAnnotation->enabled;

        $enabled === "true" ? $filters->enable(self::DELETE_FILTER) : $filters->disable(self::DELETE_FILTER);
    }
}