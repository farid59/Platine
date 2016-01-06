<?php

namespace EP\UploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EP\UploadBundle\Entity\FactureRepository")
 */
class Facture
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
     * @ORM\Column(name="Client", type="string", length=255)
     */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column(name="destinataire", type="string", length=255)
     */
    private $destinataire;

    /**
     * @var string
     *
     * @ORM\Column(name="Objet", type="text")
     */
    private $objet;

    /**
     * @var string
     *
     * @ORM\Column(name="conditionPaiement", type="text")
     */
    private $conditionPaiement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="totalHT", type="float")
     */
    private $totalHT;

    /**
     * @var float
     *
     * @ORM\Column(name="montantTVA", type="float")
     */
    private $montantTVA;

    /**
     * @var float
     *
     * @ORM\Column(name="totalTTC", type="float")
     */
    private $totalTTC;

    /**
     * @var integer
     *
     * @ORM\Column(name="pourcentage", type="integer")
     */
    private $pourcentage;

    /**
     * @var float
     *
     * @ORM\Column(name="totalFacture", type="float")
     */
    private $totalFacture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="echeance", type="datetime")
     */
    private $echeance;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaires", type="text")
     */
    private $commentaires;


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
     * Set client
     *
     * @param string $client
     *
     * @return Facture
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set destinataire
     *
     * @param string $destinataire
     *
     * @return Facture
     */
    public function setDestinataire($destinataire)
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    /**
     * Get destinataire
     *
     * @return string
     */
    public function getDestinataire()
    {
        return $this->destinataire;
    }

    /**
     * Set objet
     *
     * @param string $objet
     *
     * @return Facture
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * Get objet
     *
     * @return string
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * Set conditionPaiement
     *
     * @param string $conditionPaiement
     *
     * @return Facture
     */
    public function setConditionPaiement($conditionPaiement)
    {
        $this->conditionPaiement = $conditionPaiement;

        return $this;
    }

    /**
     * Get conditionPaiement
     *
     * @return string
     */
    public function getConditionPaiement()
    {
        return $this->conditionPaiement;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Facture
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set totalHT
     *
     * @param float $totalHT
     *
     * @return Facture
     */
    public function setTotalHT($totalHT)
    {
        $this->totalHT = $totalHT;

        return $this;
    }

    /**
     * Get totalHT
     *
     * @return float
     */
    public function getTotalHT()
    {
        return $this->totalHT;
    }

    /**
     * Set montantTVA
     *
     * @param float $montantTVA
     *
     * @return Facture
     */
    public function setMontantTVA($montantTVA)
    {
        $this->montantTVA = $montantTVA;

        return $this;
    }

    /**
     * Get montantTVA
     *
     * @return float
     */
    public function getMontantTVA()
    {
        return $this->montantTVA;
    }

    /**
     * Set totalTTC
     *
     * @param float $totalTTC
     *
     * @return Facture
     */
    public function setTotalTTC($totalTTC)
    {
        $this->totalTTC = $totalTTC;

        return $this;
    }

    /**
     * Get totalTTC
     *
     * @return float
     */
    public function getTotalTTC()
    {
        return $this->totalTTC;
    }

    /**
     * Set pourcentage
     *
     * @param integer $pourcentage
     *
     * @return Facture
     */
    public function setPourcentage($pourcentage)
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    /**
     * Get pourcentage
     *
     * @return integer
     */
    public function getPourcentage()
    {
        return $this->pourcentage;
    }

    /**
     * Set totalFacture
     *
     * @param float $totalFacture
     *
     * @return Facture
     */
    public function setTotalFacture($totalFacture)
    {
        $this->totalFacture = $totalFacture;

        return $this;
    }

    /**
     * Get totalFacture
     *
     * @return float
     */
    public function getTotalFacture()
    {
        return $this->totalFacture;
    }

    /**
     * Set echeance
     *
     * @param \DateTime $echeance
     *
     * @return Facture
     */
    public function setEcheance($echeance)
    {
        $this->echeance = $echeance;

        return $this;
    }

    /**
     * Get echeance
     *
     * @return \DateTime
     */
    public function getEcheance()
    {
        return $this->echeance;
    }

    /**
     * Set commentaires
     *
     * @param string $commentaires
     *
     * @return Facture
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    /**
     * Get commentaires
     *
     * @return string
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }
}

