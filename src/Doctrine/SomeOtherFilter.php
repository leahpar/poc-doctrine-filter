<?php

namespace App\Doctrine;

use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class SomeOtherFilter extends SQLFilter
{

    /**
     * @var Reader
     */
    private $reader;

    public function setReader(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (empty($this->reader)) {
            return '';
        }

        // The Doctrine filter is called for any query on any entity
        // Check if the current entity is "filter" (marked with an annotation)
        /** @var Filter $filterAnnotation */
        $filterAnnotation = $this->reader->getClassAnnotation(
            $targetEntity->getReflectionClass(),
            'App\\Doctrine\\Filter'
        );

        if (!$filterAnnotation) {
            return '';
        }

        // FieldName parameter in annotation
        $filterColumn = $filterAnnotation->column;

        $filterValue = $this->getParameter('filter_value');

        if (empty($filterColumn) || empty($filterValue)) {
            return '';
        }

        // Add the Where clause in the request

        return sprintf("%s.%s LIKE %s", $targetTableAlias, $filterColumn, $filterValue);
    }

}
