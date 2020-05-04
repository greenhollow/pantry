<?php

namespace GreenHollow\Pantry\Tests\Entity;

use GreenHollow\Pantry\Entity\Client;
use GreenHollow\Pantry\Tests\BaseFunctionalTestCase;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class ClientFunctionalTest extends BaseFunctionalTestCase
{
    /**
     * Verify a client with a valid relationship validates.
     */
    public function testValidateWithValidRelationship(): void
    {
        // create a client with a valid relationship
        $client = new Client();
        $client->setRelationship(Client::RELATION_PRIMARY);

        // trigger the validation
        self::$entityManager->persist($client);

        // confirm no exception occurred
        $this->assertSame('primary', $client->getRelationship());
    }

    /**
     * Verify a client with an invalid relationship will throw an exception on
     * persist.
     */
    public function testValidateWithInvalidRelationship(): void
    {
        // expect an exception
        $this->expectException(ConstraintDefinitionException::class);
        $this->expectExceptionMessage('Invalid relationship "bff" in GreenHollow\Pantry\Entity\Client; must be one of:');

        // create a client with an invalid relationship
        $client = new Client();
        $client->setRelationship('bff');

        // trigger the exception
        self::$entityManager->persist($client);
    }

    /**
     * Verify a client with a valid status validates.
     */
    public function testValidateWithValidStatus(): void
    {
        // create a client with a valid status
        $client = new Client();
        $client->setStatus(Client::STATUS_AUTHORIZED);

        // trigger the validation
        self::$entityManager->persist($client);

        // confirm no exception occurred
        $this->assertSame('authorized', $client->getStatus());
    }

    /**
     * Verify a client with an invalid status will throw an exception on
     * persist.
     */
    public function testValidateWithInvalidStatus(): void
    {
        // expect an exception
        $this->expectException(ConstraintDefinitionException::class);
        $this->expectExceptionMessage('Invalid status "lost" in GreenHollow\Pantry\Entity\Client; must be one of:');

        // create a client with an invalid status
        $client = new Client();
        $client->setStatus('lost');

        // trigger the exception
        self::$entityManager->persist($client);
    }
}
