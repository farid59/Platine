<?php

namespace EP\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EP\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct() {
        parent::__construct();
        $this->setRoles(array("ROLE_USER","ROLE_EMPTY"));
    }

    /**
     * @var EP\UserBundle\Entity\Association
	 * 
	 * @ORM\ManyToOne(targetEntity="EP\UserBundle\Entity\Association", cascade={"persist"})
     */
    protected $association = null;


    /**
     * Set association
     *
     * @param \EP\UserBundle\Entity\Association $association
     *
     * @return User
     */
    public function setAssociation(\EP\UserBundle\Entity\Association $association = null)
    {
        $this->association = $association;
        return $this;
    }

    /**
     * Get association
     *
     * @return \EP\UserBundle\Entity\Association
     */
    public function getAssociation()
    {
        return $this->association;
    }

    /*
     * Permet de joindre une association avec le role donné
     */
    private function joinRoleAndAssociaiton(\EP\UserBundle\Entity\Association $association, String $role) {
    	$this->setRoles(array($role));
    	return $this->setAssociation($association);
    }

    /**
     * setAdminOfAssociation
     *
     * @return User
     */
    public function setAdminOfAssociation(\EP\UserBundle\Entity\Association $association) {
    	return $this->joinRoleAndAssociaiton($association, "ROLE_ADMIN");
    }

    /**
     * setEmployeeOfAssociation
     *
     * @return User
     */
    public function setEmployeeOfAssociation(\EP\UserBundle\Entity\Association $association) {
    	return $this->joinRoleAndAssociaiton($association, "ROLE_EMPLOYEE");
    }

}
