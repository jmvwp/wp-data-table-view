<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Abstracts;

use MVWP\WPDataTableView\Exceptions\EntityGenerationException;

/**
 * Class AbstractEntity
 *
 * @package MVWP\WPDataTableView\Abstracts
 */
abstract class AbstractEntity
{
    /**
     * @throws EntityGenerationException
     */
    public function populateFromArray(array $data): AbstractEntity
    {
        if (! $data) {
            throw new EntityGenerationException();
        }
        foreach ($data as $property => $value) {
            if (null === $value) {
                continue;
            }
            $this->doValueSetting($property, $value);
        }

        return $this;
    }

    /**
     * @throws EntityGenerationException
     */
    // @codingStandardsIgnoreLine
    protected function doValueSetting(string $property, $value)
    {
        $setter = "change" . ucfirst($property);
        if (! method_exists($this, $setter)) {
            throw new EntityGenerationException();
        }
        if (! is_array($value)) {
            $this->$setter((string)$value);

            return;
        }
        $nestedEntity = $this->createNestedEntity($property);
        $nestedEntity->populateFromArray($value);
        $this->$setter($nestedEntity);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {

        $data = [];
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PROTECTED);

        foreach ($props as $prop) {
            $prop->setAccessible(true);
            $value = $prop->getValue($this);
            $prop->setAccessible(false);

            if ($value instanceof AbstractEntity) {
                $value = $value->toArray();
            }

            $data[ $prop->getName() ] = $value;
        }

        return $data;
    }

    /**
     * @param string $propertyName
     *
     * @return AbstractEntity
     */
    public function createNestedEntity(string $propertyName): AbstractEntity
    {

        $reflection = new \ReflectionClass($this);
        if (! $reflection->hasProperty($propertyName)) {
            $msg = "Property '{$propertyName}' does not exist in the class.";
            throw new \InvalidArgumentException($msg);
        }

        $property = $reflection->getProperty($propertyName);
        $type = $property->getType();
        if (! ($type instanceof \ReflectionNamedType && ! $type->isBuiltin())) {
            $msg = "Property '{$propertyName}' does not have a valid class type.";
            throw new \InvalidArgumentException($msg);
        }
        $propertyClassName = $type->getName();
        if (! (class_exists($propertyClassName) && is_subclass_of($propertyClassName, AbstractEntity::class))) {
            throw new \InvalidArgumentException("Class '{$propertyClassName}' does not exist.");
        }

        return new $propertyClassName();
    }
}
