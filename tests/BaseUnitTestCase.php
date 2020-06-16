<?php

namespace GreenHollow\Pantry\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;

class BaseUnitTestCase extends TestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Set a protected property's value by reflection.
     *
     * @param object $object
     * @param string $property
     * @param mixed $value
     */
    protected function setPropertyValue($object, string $property, $value): ReflectionProperty
    {
        $reflectionClass = new ReflectionClass($object);
        $reflectionProperty = $reflectionClass->getProperty($property);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $value);

        return $reflectionProperty;
    }
}
