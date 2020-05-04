<?php

namespace GreenHollow\Pantry\Tests\Entity;

use GreenHollow\Pantry\Entity\Client;
use GreenHollow\Pantry\Entity\Household;
use GreenHollow\Pantry\Tests\BaseFunctionalTestCase;
use Symfony\Component\Validator\Exception\LogicException;

class HouseholdFunctionalTest extends BaseFunctionalTestCase
{
    /**
     * Verify a household without any clients is valid.
     */
    public function testValidateWithZeroClients(): void
    {
        // create a household with an empty client collection
        $household = new Household();

        // trigger the validation
        self::$entityManager->persist($household);

        // confirm no exception occurred
        $this->assertCount(0, $household->getClients());
    }

    /**
     * Verify a household without clients including one primary is valid.
     */
    public function testValidateWithValidClients(): void
    {
        // create a household with some clients
        $household = new Household();
        $client1 = new Client($household, Client::RELATION_PRIMARY);
        $client2 = new Client($household, Client::RELATION_CHILD);
        $client2 = new Client($household, Client::RELATION_SPOUSE);
        $client2 = new Client($household, Client::RELATION_PARENT);

        // trigger the validation
        self::$entityManager->persist($household);

        // confirm no exception occurred
        $this->assertCount(4, $household->getClients());
    }

    /**
     * Verify a household without with clients where none are primary will
     * throw an exception on persist.
     */
    public function testValidateWithNoPrimaryClient(): void
    {
        // expect a logic exception
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Invalid GreenHollow\Pantry\Entity\Household; related GreenHollow\Pantry\Entity\Client list must have exactly one of "primary" relationship enabled, found 0!');

        // create a household with a client collection missing a primary
        $household = new Household();
        $client = new Client($household, Client::RELATION_CHILD);

        // trigger the exception
        self::$entityManager->persist($household);
    }

    /**
     * Verify a household without with more than one primary client will throw
     * an exception on persist.
     */
    public function testValidateWithMultiplePrimaryClients(): void
    {
        // expect a logic exception
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Invalid GreenHollow\Pantry\Entity\Household; related GreenHollow\Pantry\Entity\Client list must have exactly one of "primary" relationship enabled, found 2!');

        // create a household with multiple primary clients
        $household = new Household();
        $client1 = new Client($household, Client::RELATION_PRIMARY);
        $client2 = new Client($household, Client::RELATION_CHILD);
        $client3 = new Client($household, Client::RELATION_PRIMARY);

        // trigger the exception
        self::$entityManager->persist($household);
    }
}
