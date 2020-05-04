<?php

namespace GreenHollow\Pantry\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseFunctionalTestCase extends WebTestCase
{
    protected static ?KernelBrowser $client = null;
    protected static ?EntityManagerInterface $entityManager = null;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        if (null === self::$client) {
            self::$client = static::createClient();
        }

        if (null === self::$entityManager) {
            self::$entityManager = self::$container->get(EntityManagerInterface::class);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown(): void
    {
    }
}
