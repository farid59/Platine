<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 */
class User extends BaseUser implements ParticipantInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    public function getCanEditFacture()
    {
        return in_array("ACCESS_EDIT_FACTURE", $this->getRoles());
    }

    public function setCanEditFacture($canEditFacture)
    {
        if ($canEditFacture) {
            $this->addRole("ACCESS_EDIT_FACTURE");
        } else {
            $this->removeRole("ACCESS_EDIT_FACTURE");
        }

        return $this;
    }
}

