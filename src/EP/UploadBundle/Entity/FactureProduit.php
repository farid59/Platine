<?php

namespace EP\UploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EP\UploadBundle\Entity\FactureProduitRepository")
 */
class FactureProduit
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="quantite", type="integer")
   */
  private $quantite;

  /**
   * @ORM\ManyToOne(targetEntity="EP\UploadBundle\Entity\Facture", inversedBy="produits", cascade={"remove", "persist"})
   * @ORM\JoinColumn(nullable=false)
   */
  private $facture;

  /**
   * @ORM\ManyToOne(targetEntity="EP\UploadBundle\Entity\Produit", cascade={"remove", "persist"})
   * @ORM\JoinColumn(nullable=false)
   */
  private $produit;
  

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return FactureProduit
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set facture
     *
     * @param \EP\UploadBundle\Entity\Facture $facture
     *
     * @return FactureProduit
     */
    public function setFacture(\EP\UploadBundle\Entity\Facture $facture)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \EP\UploadBundle\Entity\Facture
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set produit
     *
     * @param \EP\UploadBundle\Entity\Produit $produit
     *
     * @return FactureProduit
     */
    public function setProduit(\EP\UploadBundle\Entity\Produit $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \EP\UploadBundle\Entity\Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }
}
