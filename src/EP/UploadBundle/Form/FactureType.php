<?php

namespace EP\UploadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FactureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client', 'entity', array(
                "class" => "EPUploadBundle:Client",
                "choice_label" => "displayName",
                'by_reference' => true ,
            ))    
            ->add('destinataire','text')
            ->add('objet')
            ->add('conditionPaiement')
            // ->add('date')
            ->add('totalHT', 'hidden')
            ->add('montantTVA', 'hidden')
            ->add('totalTTC', 'hidden')
            ->add('pourcentage')
            ->add('totalFacture', 'hidden')
            ->add('echeance')
            ->add('commentaires')
            ->add('produits', 'collection', array(
                'type' => new FactureProduitType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => true //Permet d'enregistrer un produit avec sa quantité avant la persistence de la facture, car on n'a toujours pas son id
            ))
            ->add('enregistrer','submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EP\UploadBundle\Entity\Facture'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ep_uploadbundle_facture';
    }
}
