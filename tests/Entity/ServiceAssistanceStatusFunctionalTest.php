<?php

namespace GreenHollow\Pantry\Tests\Entity;

use GreenHollow\Pantry\Entity\ServiceAssistanceStatus;
use GreenHollow\Pantry\Tests\BaseFunctionalTestCase;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class ServiceAssistanceStatusFunctionalTest extends BaseFunctionalTestCase
{
    /**
     * Verify a service assistance status with a valid status validates.
     */
    public function testValidateWithValidStatus(): void
    {
        // create a service assistance status with a valid status
        $serviceAssistanceStatus = new ServiceAssistanceStatus();
        $serviceAssistanceStatus->setStatus(ServiceAssistanceStatus::STATUS_APPLIED);

        // trigger the validation
        self::$entityManager->persist($serviceAssistanceStatus);

        // confirm no exception occurred
        $this->assertSame('applied', $serviceAssistanceStatus->getStatus());
    }

    /**
     * Verify a service assistance status with an invalid status will throw an
     * exception on persist.
     */
    public function testValidateWithInvalidStatus(): void
    {
        // expect an exception
        $this->expectException(ConstraintDefinitionException::class);
        $this->expectExceptionMessage('Invalid status "misspelled" in GreenHollow\Pantry\Entity\ServiceAssistanceStatus; must be one of:');

        // create a service assistance status with an invalid status
        $serviceAssistanceStatus = new ServiceAssistanceStatus();
        $serviceAssistanceStatus->setStatus('misspelled');

        // trigger the exception
        self::$entityManager->persist($serviceAssistanceStatus);
    }
}
