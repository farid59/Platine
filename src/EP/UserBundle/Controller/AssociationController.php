<?php

namespace EP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use EP\UserBundle\Entity\Association;

class AssociationController extends Controller
{

	/**
	 * @Security("has_role('ROLE_EMPTY')")
	 */
    public function createAction()
    {
    	$association = new Association();
    	$association->setName("La petite marie");
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($association);

    	$user = $this->container->get('security.context')->getToken()->getUser();
    	$user->setAdminOfAssociation($association);

    	$em->flush();

    	$token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken(
          $user,
          null,
          'main',
          $user->getRoles()
        );
        $this->container->get('security.context')->setToken($token);


        return $this->render('EPUserBundle:Association:create.html.twig', array(
                // ...
            ));    
    }

	/**
	 * @Security("has_role('ROLE_EMPTY')")
	 */
    public function joinAction() {

        return $this->render('EPUserBundle:Association:join.html.twig', array(
                // ...
            ));    
    }

	/**
	 * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_EMPLOYEE')")
	 */
    public function leaveAction() {

    	$user = $this->container->get('security.context')->getToken()->getUser();
    	$user->leaveAssociation();

    	$this->getDoctrine()->getManager()->flush();

		$token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken(
          $user,
          null,
          'main',
          $user->getRoles()
        );
        $this->container->get('security.context')->setToken($token);


        return $this->render('EPUserBundle:Association:leave.html.twig', array(
                // ...
            ));    
    }

}
