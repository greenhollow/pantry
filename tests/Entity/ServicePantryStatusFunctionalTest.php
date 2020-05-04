<?php

namespace GreenHollow\Pantry\Tests\Entity;

use GreenHollow\Pantry\Entity\ServicePantryStatus;
use GreenHollow\Pantry\Tests\BaseFunctionalTestCase;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class ServicePantryStatusFunctionalTest extends BaseFunctionalTestCase
{
    /**
     * Verify a service pantry status with a valid status validates.
     */
    public function testValidateWithValidStatus(): void
    {
        // create a service pantry status with a valid status
        $servicePantryStatus = new ServicePantryStatus();
        $servicePantryStatus->setStatus(ServicePantryStatus::STATUS_COMPLETE);

        // trigger the validation
        self::$entityManager->persist($servicePantryStatus);

        // confirm no exception occurred
        $this->assertSame('complete', $servicePantryStatus->getStatus());
    }

    /**
     * Verify a service pantry status with an invalid status will throw an
     * exception on persist.
     */
    public function testValidateWithInvalidStatus(): void
    {
        // expect an exception
        $this->expectException(ConstraintDefinitionException::class);
        $this->expectExceptionMessage('Invalid status "misspelled" in GreenHollow\Pantry\Entity\ServicePantryStatus; must be one of:');

        // create a service pantry status with an invalid status
        $servicePantryStatus = new ServicePantryStatus();
        $servicePantryStatus->setStatus('misspelled');

        // trigger the exception
        self::$entityManager->persist($servicePantryStatus);
    }
}
