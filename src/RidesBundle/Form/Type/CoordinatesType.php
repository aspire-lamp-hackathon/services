<?php
namespace RidesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Document\Coordinates;

class CoordinatesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('longtitude', 'text');
        $builder->add('latitude', 'text');
    }

    public function getName()
    {
        return 'coordinates';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Document\Coordinates',
            'csrf_protection' => false
        ));
    }
}