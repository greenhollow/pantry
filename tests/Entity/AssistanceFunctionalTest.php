<?php

namespace GreenHollow\Pantry\Tests\Entity;

use GreenHollow\Pantry\Entity\Assistance;
use GreenHollow\Pantry\Entity\Client;
use GreenHollow\Pantry\Tests\BaseFunctionalTestCase;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class AssistanceFunctionalTest extends BaseFunctionalTestCase
{
    /**
     * Verify an assistance with a valid type validates.
     */
    public function testValidateWithValidType(): void
    {
        // create an assistance with a valid type
        $assistance = new Assistance(new Client());
        $assistance->setType(Assistance::TYPE_MEDICARE);

        // trigger the validation
        self::$entityManager->persist($assistance);

        // confirm no exception occurred
        $this->assertSame('medicare', $assistance->getType());
    }

    /**
     * Verify an assistance with an invalid type will throw an exception on
     * persist.
     */
    public function testValidateWithInvalidType(): void
    {
        // expect an exception
        $this->expectException(ConstraintDefinitionException::class);
        $this->expectExceptionMessage('Invalid type "mediocre" in GreenHollow\Pantry\Entity\Assistance; must be one of:');

        // create an assistance with an invalid type
        $assistance = new Assistance(new Client());
        $assistance->setType('mediocre');

        // trigger the exception
        self::$entityManager->persist($assistance);
    }
}
