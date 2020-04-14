<?php

namespace GreenHollow\Pantry\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseFunctionalTestCase extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\KernelBrowser
     */
    protected $client;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown(): void
    {
        unset($this->client);
    }
}
