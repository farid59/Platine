<?php

namespace EP\UploadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FactureProduitType extends AbstractType
{
    private $loggedUser;

    public function __construct($user) {
        $this->loggedUser = $user;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('quantite')
            ->add('produit', 'entity', array(
                "class" => "EPUploadBundle:Produit",
                "choice_label" => "designation",
                'by_reference' => true ,
                'query_builder' => function (\EP\UploadBundle\Entity\ProduitRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->andwhere('p.owner = :user')
                        ->setParameter('user', $this->loggedUser);
                },
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EP\UploadBundle\Entity\FactureProduit'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ep_uploadbundle_factureproduit';
    }
}
