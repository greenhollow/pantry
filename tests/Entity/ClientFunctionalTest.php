<?php

namespace GreenHollow\Pantry\Tests\Entity;

use GreenHollow\Pantry\Dto\ClientDto;
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
        $client = new Client(null, Client::RELATION_INDIVIDUAL);

        // trigger the validation
        self::$entityManager->persist($client);

        // confirm no exception occurred
        $this->assertSame('self', $client->getRelationship());
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
        $client = new Client(null, 'bff');

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
        $clientDto = ClientDto::create($client);
        $clientDto->status = Client::STATUS_AUTHORIZED;
        $client->update($clientDto);

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
        $clientDto = ClientDto::create($client);
        $clientDto->status = 'lost';
        $client->update($clientDto);

        // trigger the exception
        self::$entityManager->persist($client);
    }
}
