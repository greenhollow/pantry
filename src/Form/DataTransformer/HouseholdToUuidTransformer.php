<?php

namespace GreenHollow\Pantry\Form\DataTransformer;

use Doctrine\ORM\EntityManagerInterface;
use GreenHollow\Pantry\Entity\Household;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class HouseholdToUuidTransformer implements DataTransformerInterface
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $entityManager;

    /**
     * The constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms a Household entity to a UUID.
     */
    public function transform($household): string
    {
        if (!($household instanceof Household)) {
            return '';
        }

        return $household->getUuid();
    }

    /**
     * Transforms a UUID to a Household entity.
     *
     * @throws TransformationFailedException if Household is not found
     */
    public function reverseTransform($uuid)
    {
        if (!$uuid || !is_string($uuid)) {
            return;
        }

        $household = $this->entityManager->getRepository(Household::class)
            ->findOneBy(['uuid' => $uuid])
        ;

        if (null === $household) {
            $exception = new TransformationFailedException(sprintf('Household not found on reverse transform of UUID "%s"', $uuid));
            $exception->setInvalidMessage('Could not find household identified by "%uuid%"!', ['%uuid%' => $uuid]);

            throw $exception;
        }

        return $household;
    }
}
