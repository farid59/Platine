<?php

namespace EP\UploadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('civilite', 'choice', array(
                    'choices' => array(
                        'Mr' => 'Mr',
                        'Mme' => 'Mme',
                        'Mlle' => 'Mlle',
                    ),
                    'expanded' => true,
                    'multiple' => false,
                    'choices_as_values' => true,
                ))
            ->add('email', 'email')
            ->add('societe')
            ->add('destinataire')
            ->add('adresse')
            ->add('codePostal')
            ->add('ville')
            ->add('pays')
            ->add('telephone')
            ->add('mobile')
            ->add('fax')
            ->add('tva')
            ->add('reference')
            ->add('conditionPaiement', null, array(
                "required" => false
            ))
            ->add('valider','submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EP\UploadBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ep_uploadbundle_client';
    }
}
