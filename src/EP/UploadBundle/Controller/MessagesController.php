<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use EP\UploadBundle\Entity\Files;

class MessagesController extends Controller
{
    public function messagesAction($id)
    {

        $provider = $this->container->get('fos_message.provider');

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $threads = $provider->getSentThreads();
        } else {
            $threads = $provider->getInboxThreads();
        }

        if ($id === null) {
            $thread = count($threads) === 0 ? null : $threads[0];
        } else {
            $thread = $provider->getThread($id);
        }

        return $this->render('EPUploadBundle:Messages:messages.html.twig', array(
            'threads' => $threads,
            'thread' => $thread,
        ));    
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function sendMessageAction()
    {
        $ur = $this->getDoctrine()->getManager()->getRepository("AppBundle:User");
       $form = $this->createFormBuilder()
            ->add("Subject","text")
            ->add("Body","hidden")
            ->add("Destinataires","entity",array(
                "class" => "AppBundle:User",
                "choice_label" => "username",
                "by_reference" => true,
                "multiple" => true,
                'query_builder' =>  $ur->findWithoutRole("ROLE_ADMIN",true)
            ))
            ->add("Attachment", "file", array( "required" => false ))
            ->add("Envoyer","submit")
            ->getForm();


        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $formData = $form->getData();

            $category_comptable = $this->getDoctrine()->getManager()->getRepository("EPUploadBundle:Category")->findOneByName('Comptable');
            $messageContent = $formData["Body"];

            if ($formData["Attachment"] !== null) {
                var_dump($formData["Attachment"]);

                $file = new Files();
                $file->setOwner($this->container->get('security.context')->getToken()->getUser());
                $file->setCategory($category_comptable);
                $file->setFile($formData["Attachment"]);
                $em = $this->getDoctrine()->getManager();
                $em->persist($file);
                // $em->flush();
                // $messageContent .= $this->renderView("EPUploadBundle:Messages:attachment.html.twig", array(
                //     "doc" => $file
                // ));
            }

            $currentUser = $this->container->get('security.context')->getToken()->getUser();
            $composer = $this->container->get('fos_message.composer');
            
            $messageBuilder = $composer->newThread()
                ->setSender($currentUser)
                ->setSubject($formData["Subject"])
                ->setBody($messageContent);

            foreach ($formData["Destinataires"] as $user) {
                $messageBuilder->addRecipient($user);
            }

            $message = $messageBuilder->getMessage();
            $message->setFile($file);

            $sender = $this->container->get('fos_message.sender');
            $sender->send($message);


            return $this->redirectToRoute("ep_messages");
        }

        return $this->render('EPUploadBundle:Messages:sendMessage.html.twig', array(
            'form' => $form->createView(),
        ));    
    }

}
