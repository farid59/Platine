<?php

namespace EP\UploadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProduitType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation','text')
            ->add('description','text')
            ->add('reference','text')
            ->add('montantUnitaireHT','number')
            ->add('tva', 'choice', array(
                'choices' => array(
                    '20' => 20.0,
                    '10' => 10.0,
                    '5,5' => 5.5,
                    '2,1' => 2.1,
                ),
                'multiple' => false,
                'expanded' => false,
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
            'data_class' => 'EP\UploadBundle\Entity\Produit'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ep_uploadbundle_produit';
    }
}
