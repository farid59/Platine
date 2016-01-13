<?php

namespace EP\UploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EP\UploadBundle\Entity\ProduitRepository")
 */
class Produit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Designation", type="text")
     */
    private $designation;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255)
     */
    private $reference;

    /**
     * @var float
     *
     * @ORM\Column(name="montantUnitaireHT", type="float")
     */
    private $montantUnitaireHT;

    /**
     * @var float
     *
     * @ORM\Column(name="TVA", type="float")
     */
    private $tva;

    /**
     * @var AppBundle\Entity\User
     *
     * @ORM\ManyToOne( targetEntity="AppBundle\Entity\User", cascade={"persist"} )
     */
    private $owner;

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
     * Set designation
     *
     * @param string $designation
     *
     * @return Produit
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Produit
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set montantUnitaireHT
     *
     * @param float $montantUnitaireHT
     *
     * @return Produit
     */
    public function setMontantUnitaireHT($montantUnitaireHT)
    {
        $this->montantUnitaireHT = $montantUnitaireHT;

        return $this;
    }

    /**
     * Get montantUnitaireHT
     *
     * @return float
     */
    public function getMontantUnitaireHT()
    {
        return $this->montantUnitaireHT;
    }

    /**
     * Set owner
     *
     * @param \AppBundle\Entity\User $owner
     *
     * @return Produit
     */
    public function setOwner(\AppBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \AppBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set tva
     *
     * @param float $tva
     *
     * @return Produit
     */
    public function setTva($tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return float
     */
    public function getTva()
    {
        return $this->tva;
    }

    public function getMontantUnitaireTTC()
    {
        return $this->montantUnitaireHT * (100 + $this->getTva()) / 100;
    }
}
