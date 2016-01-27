<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('nom')
                ->add('prenom')
                ->add('societe')
                ->add('adresse')
                ->add('ville')
                ->add('pays')
                ->add('codepostal')
                ->add('telephone')
                // ->add('file')
                ;
    }

    public function getName()
    {
        return 'app_user_registration';
    }
}