<?php

namespace GreenHollow\Pantry\Form\Type;

use GreenHollow\Pantry\Dto\ClientDto;
use GreenHollow\Pantry\Form\DataTransformer\HouseholdToUuidTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A form to capture all the data necessary to create or update a client.
 */
class ClientType extends AbstractType
{
    /**
     * @var HouseholdToUuidTransformer
     */
    protected $householdToUuidTransformer;

    /**
     * The constructor.
     */
    public function __construct(HouseholdToUuidTransformer $householdToUuidTransformer)
    {
        $this->householdToUuidTransformer = $householdToUuidTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('allergic', CheckboxType::class)
            ->add('diabetic', CheckboxType::class)
            ->add('dob', DateType::class)
            ->add('firstName', TextType::class)
            ->add('gender', TextType::class)
            ->add('household', TextType::class)
            ->add('lastName', TextType::class)
            ->add('relationship', TextType::class)
            ->add('status', TextType::class)
        ;

        $builder->get('household')->addModelTransformer($this->householdToUuidTransformer);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClientDto::class,
        ]);
    }
}
