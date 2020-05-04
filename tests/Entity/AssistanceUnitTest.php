<?php

namespace GreenHollow\Pantry\Tests\Entity;

use DateTime;
use GreenHollow\Pantry\Entity\Assistance;
use GreenHollow\Pantry\Entity\Client;
use GreenHollow\Pantry\Entity\Household;
use GreenHollow\Pantry\Tests\BaseUnitTestCase;
use Symfony\Component\Validator\Exception\LogicException;

class AssistanceUnitTest extends BaseUnitTestCase
{
    /**
     * Verify that an assistance can be constructed in relation to a household.
     */
    public function testConstructWithHousehold(): void
    {
        // configure a household
        $household = new Household();

        // instantiate with the household
        $assistance = new Assistance($household);

        // confirm the associations
        $this->assertSame($household, $assistance->getHousehold());
        $this->assertNull($assistance->getClient());
    }

    /**
     * Verify that an assistance can be constructed in relation to a client.
     */
    public function testConstructWithClient(): void
    {
        // configure a client
        $client = new Client();

        // instantiate with the client
        $assistance = new Assistance($client);

        // confirm the associations
        $this->assertSame($client, $assistance->getClient());
        $this->assertNull($assistance->getHousehold());
    }

    /**
     * Verify attempting to disable a disabled assistance throws an exception.
     */
    public function testDisableWhenAlreadyDisabled(): void
    {
        // expect an exception
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('GreenHollow\Pantry\Entity\Assistance is already disabled!');

        // configure a disabled assistance
        $assistance = new Assistance(new Client());
        $assistance->setDisabled(new DateTime());

        // trigger the exception
        $assistance->disable();
    }

    /**
     * Verify that an assistence can be disabled.
     */
    public function testDisableWhenNotDisabled(): void
    {
        // configure an enabled assistance
        $assistance = new Assistance(new Client());

        // disable the instance
        $assistance->disable();

        // confirm the assistance was disabled
        $this->assertInstanceOf(DateTime::class, $assistance->getDisabled());
    }

    /**
     * Verify the valid assistance types.
     */
    public function testGetTypes(): void
    {
        $this->assertSame(
            [
                'chips',
                'food_stamps',
                'medicaid',
                'medicare',
                'veterans',
                'wic',
            ],
            Assistance::getTypes()
        );
    }

    /**
     * Verify that an assistance can be checked for being disabled.
     */
    public function testIsDisabled(): void
    {
        // configure an enabled assistance
        $assistance = new Assistance(new Client());

        // confirm the assistance is not disabled
        $this->assertFalse($assistance->isDisabled());

        // disable the instance
        $assistance->disable();

        // confirm the assistance is disabled
        $this->assertTrue($assistance->isDisabled());
    }

    /**
     * Verify that an assistance can be checked for being enabled.
     */
    public function testIsEnabled(): void
    {
        // configure an enabled assistance
        $assistance = new Assistance(new Client());

        // confirm the assistance is enabled
        $this->assertTrue($assistance->isEnabled());

        // disable the instance
        $assistance->disable();

        // confirm the assistance is not enabled
        $this->assertFalse($assistance->isEnabled());
    }
}
