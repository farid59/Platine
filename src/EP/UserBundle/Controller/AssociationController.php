<?php

namespace EP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use EP\UserBundle\Entity\Association;
use EP\UserBundle\Form\AssociationType;
use Symfony\Component\HttpFoundation\Request;

class AssociationController extends Controller
{

	/**
	 * @Security("has_role('ROLE_EMPTY')")
	 */
    public function createAction(Request $request)
    {
    	// $association = new Association();
    	// $association->setName("La petite marie");
    	// $em = $this->getDoctrine()->getManager();
    	// $em->persist($association);

    	// $user = $this->container->get('security.context')->getToken()->getUser();
    	// $user->setAdminOfAssociation($association);

    	// $em->flush();

    	// $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken(
     //      $user,
     //      null,
     //      'main',
     //      $user->getRoles()
     //    );
     //    $this->container->get('security.context')->setToken($token);

        $association = new Association();
        $form = $this->get('form.factory')->create(new AssociationType(), $association);

        if($form->handleRequest($request)->isValid()) {
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

          return $this->redirect($this->generateUrl('ep_user_homepage'));
        }

        return $this->render('EPUserBundle:Association:create.html.twig', array(
                'form' => $form->createView()
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
