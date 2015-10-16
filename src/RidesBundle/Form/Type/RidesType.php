<?php
namespace RidesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Document\Coordinates;

class RidesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateOfJourney', 'date', array(
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'required' => true,
            'invalid_message' => 'Date should be in the format yyyy-MM-dd'
        ));
        $builder->add('source', new CoordinatesType());
        $builder->add('destination', new CoordinatesType());
        $builder->add('persons', 'text');
        $builder->add('rideOfferInd', 'choice', array(
            'expanded' => true,
            'multiple' => false,
            'choices' => array(
                '0' => 'No',
                '1' => 'Yes'
            ),
            'invalid_message' => 'Please provide 0 or 1 to indicate offering a ride of search for a ride'
        ));
    }

    public function getName()
    {
        return 'ride';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Document\Ride',
            'csrf_protection' => false,
            'cascade_validation' => true
        ));
    }
}