<?php
namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email');
        $builder->add('mobile', 'number');
        $builder->add('name', 'email');        
        $builder->add('password', 'text');
        $builder->add('confirm_password', 'text');
    }

    public function getName()
    {
        return 'register';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Document\User',
            'csrf_protection' => false
        ));
    }
}