<?php

namespace AppBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class DeleteAware
 *
 * @package AppBundle\Annotation
 *
 * @Annotation()
 * @Annotation\Target("CLASS")
 */
final class DeleteAware
{
    public $deleteFieldName;
}