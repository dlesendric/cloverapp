<?php

namespace AppBundle\Filter;


use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * Class DeleteFilter
 *
 * @package AppBundle\Filter
 */
class DeleteFilter extends SQLFilter
{
    /** @var  Reader $reader */
    protected $reader;

    /**
     * Gets the SQL query part to add to a query.
     *
     * @param ClassMetaData $targetEntity
     * @param string        $targetTableAlias
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (empty($this->reader)) {
            return '';
        }

        // The Doctrine filter is called for any query on any entity
        // Check if the current entity is "delete aware" (marked with an annotation)
        $deleteAware = $this->reader->getClassAnnotation(
            $targetEntity->getReflectionClass(),
            'AppBundle\\Annotation\\DeleteAware'
        );

        if (!$deleteAware) {
            return '';
        }

        $fieldName = $deleteAware->deleteFieldName;
        $deletedParam = trim($this->getParameter('deleted'), "'");
        $deleted = is_numeric($deletedParam) ? (bool)(int)$deletedParam : null;

        if (empty($fieldName) || $deleted === null) {
            return '';
        }

        $condition = $deleted === true ? 'IS NOT NULL' : 'IS NULL';

        $query = sprintf('%s.%s %s', $targetTableAlias, $fieldName, $condition);

        return $query;
    }

    /**
     * @param Reader $reader
     */
    public function setAnnotationReader(Reader $reader)
    {
        $this->reader = $reader;
    }
}