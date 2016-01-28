<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MessagesController extends Controller
{
    public function messagesAction()
    {
        $provider = $this->container->get('fos_message.provider');

        $threadsIn = $provider->getInboxThreads();
        $threadsOut = $provider->getSentThreads();
        $currentThread = null;
        
        if (count($threadsIn) > 0) {
            $currentThread = $provider->getThread($threadsIn[0]->getId());
        } else if (count($threadsOut) > 0) {
            $currentThread = $provider->getThread($threadsOut[0]->getId());
        }

        $form = $this->createFormBuilder()
            ->add("Message","textarea")
            ->add("Envoyer","submit")
            ->getForm();

        if ($form->handleRequest($this->getRequest())->isValid()) {
            $formData = $form->getData();

            $composer = $this->container->get('fos_message.composer');
            $message = $composer->reply($currentThread)
                ->setSender($this->container->get('security.context')->getToken()->getUser())
                ->setBody($formData["Message"])
                ->getMessage();

            $sender = $this->container->get('fos_message.sender');
            $sender->send($message);
        }

        return $this->render('EPUploadBundle:Messages:messages.html.twig', array(
            'threadsIn' => $threadsIn,
            'threadsOut' => $threadsOut,
            'currentThread' => $currentThread,
            'form' => $form->createView()
        ));    
    }

    public function sendMessageAction()
    {
        $form = $this->createFormBuilder()
            ->add("Subject","text")
            ->add("Body","text")
            ->add("Envoyer","submit")
            ->getForm();


        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            $formData = $form->getData();

            $from = $this->container->get('security.context')->getToken()->getUser();
            $to = $this->getDoctrine()->getManager()->getRepository("AppBundle:User")->findOneByRole("ROLE_ADMIN");

            $composer = $this->container->get('fos_message.composer');
            $message = $composer->newThread()
                ->setSender($from)       // Envoyeur
                ->addRecipient($to)    // Destinataire
                ->setSubject($formData["Subject"])      // Sujet
                ->setBody($formData["Body"])         // Contenu
                ->getMessage();

            $sender = $this->container->get('fos_message.sender');
            $sender->send($message);

            return $this->redirectToRoute("ep_messages");
        }

        return $this->render('EPUploadBundle:Messages:sendMessage.html.twig', array(
            'form' => $form->createView(),
        ));    
    }

    public function messageAction()
    {
        return $this->render('EPUploadBundle:Messages:message.html.twig', array(
                // ...
            ));    
    }

}
