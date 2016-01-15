<?php

namespace EP\UploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Client
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EP\UploadBundle\Entity\ClientRepository")
 */
class Client
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
     * @ORM\Column(name="Nom", type="string", length=255)
     * @Assert\Regex(pattern = "/\d/", match = false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=255)
     * @Assert\Regex(pattern = "/\d/", match = false)
     */
    private $prenom;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Civilite", type="string", length=10)
     */
    private $civilite;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Societe", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $societe;

    /**
     * @var string
     *
     * @ORM\Column(name="destinataire", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $destinataire;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="codePostal", type="string", length=6)
     * @Assert\Regex(pattern="/^\d{5,6}$/")
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="Pays", type="string", length=255)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255)
     * @Assert\Regex(pattern="/^\d{10}$/")
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=255)
     * @Assert\Regex(pattern="/^\d{10}$/")
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255)
     * @Assert\Regex(pattern="/^\d{10}$/")
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="tva", type="string", length=255)
     */
    private $tva;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="conditionPaiement", type="text")
     */
    private $conditionPaiement;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Client
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Client
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }



    /**
     * Set email
     *
     * @param string $email
     *
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set societe
     *
     * @param string $societe
     *
     * @return Client
     */
    public function setSociete($societe)
    {
        $this->societe = $societe;

        return $this;
    }

    /**
     * Get societe
     *
     * @return string
     */
    public function getSociete()
    {
        return $this->societe;
    }

    /**
     * Set destinataire
     *
     * @param string $destinataire
     *
     * @return Client
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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Client
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return Client
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Client
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Client
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Client
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return Client
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set fax
     *
     * @param string $fax
     *
     * @return Client
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set tva
     *
     * @param string $tva
     *
     * @return Client
     */
    public function setTva($tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return string
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Client
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
     * Set conditionPaiement
     *
     * @param string $conditionPaiement
     *
     * @return Client
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
     * Set owner
     *
     * @param \AppBundle\Entity\User $owner
     *
     * @return Client
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
     * Set civilite
     *
     * @param boolean $civilite
     *
     * @return Client
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return boolean
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Get displayName
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->nom.", ".$this->prenom;
    }

    /**
     * @Assert\Callback
     */
    public function validateTva(ExecutionContextInterface $context)
    {
        $error = 1;

        $tva = $this->tva;
        $pays = substr($tva, 0, 2);
        $code = substr($tva, 2);

        // informations récupérées sur https://saturn.etat.lu/etva/construction.do
        switch($pays) {
            // Belgique : 10 chiffres
            case "BE" : $error = preg_match("#^[0-9]{10}$#", $code); break;
            // Danemark : 4 blocs de 2 chiffres
            case "DK" : $error = preg_match("#^([0-9]{2}\s?){3}[0-9]{2}$#", $code); break;
            // Allemagne : 1 bloc de 9 chiffres
            case "DE" : $error = preg_match("#^[0-9]{9}$#", $code); break;
            // Grèce : 1 bloc de 9 chiffres
            case "EL" : $error = preg_match("#^[0-9]{10}$#", $code); break;
            // Espagne : 1 bloc de 9 caractères. Le premier et le dernier caractère 
            // peuvent être de type alphabétique ou numérique mais ils ne peuvent 
            // pas être tous les deux numériques.
            case "ES" : 
                $error = preg_match("#^[A-Z0-9]{9}$#", $code); 
                $first = substr($code, 0, 1);
                $last = substr($code, strlen($code)-1, 1);
                if (preg_match("#[0-9]#", $first) === 1 && preg_match("#[0-9]#", $last) === 1 ) {
                    $error = 0;
                }
                break;
            // France : 1 bloc de 2 caractères et 1 bloc de 9 chiffres
            case "FR" : $error = preg_match("#^[A-Z0-9]{2}[0-9]{9}$#", $code); break;
            // Irlande : 1 bloc de 8 caractères dont le 2e est un chiffre, une lettre, * ou +,
            //  et le dernier est une lettre, les autres sont des chiffres
            case "IE" : $error = preg_match("#^[0-9][0-9A-Z\+\*][0-9]{5}[A-Z]$#", $code); break;
            // Italie : 1 bloc de 11 chiffres
            case "IT" : $error = preg_match("#^[0-9]{11}$#", $code); break;
            // Luxembourg : 1 bloc de 8 chiffres
            case "LU" : $error = preg_match("#^[0-9]{8}$#", $code); break;
            // Pays-Bas : 1 bloc de 12 caractères. La 10 position suivant le préfixe
            // code pays est toujours un B
            case "NL" : $error = preg_match("#^[0-9A-Z]{9}B[0-9A-Z]{2}$#", $code); break;
            // Autriche : Un bloc de 9 caractères. La première position suivant le
            // préfixe code pays est toujours U
            case "AT" : $error = preg_match("#^U[0-9]{8}$#", $code); break;
            // Portugal : un bloc de 9 chiffres
            case "PT" : $error = preg_match("#^[0-9]{9}$#", $code); break;
            // Finlande : un bloc de 8 chiffres
            case "FI" : $error = preg_match("#^[0-9]{8}$#", $code); break;
            // Suède : un bloc de 12 chiffres
            case "SE" : $error = preg_match("#^[0-9]{12}$#", $code); break;
            // Grande bretagne : 4 formats possibles :
            //      - 1 bloc de 3, 1 bloc de 4 et 1 bloc de 2 chiffres
            //      - même format + 1 bloc de 3 vhiffres (pour identifier la branche de l'assujetti)
            //      - 1 bloc de 5 caractères commençant par GD (pour identifier le gouvernement départemental)
            //      - 1 bloc de 5 caractères commençant par HA (pour identifier l'autorité de santé)
            case "GB" : 
                if (0 === preg_match("#^[0-9]{3}\s?[0-9]{4}\s?[0-9]{2}$#", $code)
                 && 0 === preg_match("#^[0-9]{3}\s?[0-9]{4}\s?[0-9]{2}\s?[0-9]{2}$#", $code)
                 && 0 === preg_match("#^GD[A-Z0-9]{3}$#", $code)
                 && 0 === preg_match("#^HA[A-Z0-9]{3}$#", $code)
                ) {
                    $error = 0;
                }
                break;
            // Chypre : 1 bloc de 8 chiffres et 1 lettre
            case "CY" : $error = preg_match("#^[0-9]{8}[A-Z]$#", $code); break;
            // République Tchèque : 1 bloc de 8, 9 ou 10 caractères
            case "CZ" : $error = preg_match("#^[A-Z0-9]{8,10}$#", $code); break;
            // Estonie : 1 bloc de 9 chiffres
            case "EE" : $error = preg_match("#^[0-9]{9}$#", $code); break;
            // Lettonie : 1 bloc de 11 chiffres
            case "LV" : $error = preg_match("#^[0-9]{11}$#", $code); break;
            // Lituanie : 1 bloc de 9 ou 12 chiffres
            case "LT" : $error = preg_match("#(^[0-9]{9}$)|(^[0-9]{12}$)#", $code); break;
            // Hongrie : 1 bloc de 8 chiffres
            case "HU" : $error = preg_match("#^[0-9]{8}$#", $code); break;
            // Malte : 1 bloc de 8 chiffres
            case "MT" : $error = preg_match("#^[0-9]{8}$#", $code); break;
            // Pologne : 1 bloc de 10 chiffres
            case "PL" : $error = preg_match("#^[0-9]{10}$#", $code); break;
            // Slovénie : 1 bloc de 8 chiffres
            case "SI" : $error = preg_match("#^[0-9]{8}$#", $code); break;
            // République slovaque : 1 bloc de 10 chiffres
            case "SK" : $error = preg_match("#^[0-9]{10}$#", $code); break;
            // Bulgarie : 1 bloc de 9 ou 10 chiffres
            case "BG" : $error = preg_match("#^[0-9]{9,10}$#", $code); break;
            // Roumanie : 1 bloc de minimum 2 chiffres et maximum 10 chiffres
            case "RO" : $error = preg_match("#^[0-9]{2,10}$#", $code); break;
            // Croatie : 1 bloc de 11 chiffres
            case "HR" : $error = preg_match("#^[0-9]{11}$#", $code); break;
            default: $error = 0; break; 
        }

        if (0 === $error) {
            $context->buildViolation('Le format du numero de TVA Intracommunautaire n\'est pas valide.')
                    ->atPath('tva')
                    ->addViolation();
        }
    }
}
