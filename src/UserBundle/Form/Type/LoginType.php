<?php
namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('userid', 'text', array(
            'constraints' => new NotBlank(array(
                'message' => 'Email / Mobile cannot be blank'
            ))
        ));
        $builder->add('password', 'text', array(
            'constraints' => new NotBlank(array(
                'message' => 'Password cannot be blank'
            ))
        ));
    }

    public function getName()
    {
        return 'register';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }
}