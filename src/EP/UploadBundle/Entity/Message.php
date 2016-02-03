<?php
// src/Acme/MessageBundle/Entity/Message.php

namespace EP\UploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\MessageBundle\Entity\Message as BaseMessage;

/**
 * @ORM\Entity
 */
class Message extends BaseMessage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(
     *   targetEntity="EP\UploadBundle\Entity\Thread",
     *   inversedBy="messages"
     * )
     * @var \FOS\MessageBundle\Model\ThreadInterface
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @var \FOS\MessageBundle\Model\ParticipantInterface
     */
    protected $sender;

    /**
     * 
     * @ORM\OneToOne( targetEntity="EP\UploadBundle\Entity\Files" )
     */
    protected $file;

    /**
     * @ORM\OneToMany(
     *   targetEntity="EP\UploadBundle\Entity\MessageMetadata",
     *   mappedBy="message",
     *   cascade={"all"}
     * )
     * @var MessageMetadata[]|\Doctrine\Common\Collections\Collection
     */
    protected $metadata;

    /**
     * Add metadatum
     *
     * @param \EP\UploadBundle\Entity\MessageMetadata $metadatum
     *
     * @return Message
     */
    public function addMetadatum(\EP\UploadBundle\Entity\MessageMetadata $metadatum)
    {
        $this->metadata[] = $metadatum;

        return $this;
    }

    /**
     * Remove metadatum
     *
     * @param \EP\UploadBundle\Entity\MessageMetadata $metadatum
     */
    public function removeMetadatum(\EP\UploadBundle\Entity\MessageMetadata $metadatum)
    {
        $this->metadata->removeElement($metadatum);
    }

    /**
     * Get metadata
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Set file
     *
     * @param \EP\UploadBundle\Entity\Files $file
     *
     * @return Message
     */
    public function setFile(\EP\UploadBundle\Entity\Files $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \EP\UploadBundle\Entity\Files
     */
    public function getFile()
    {
        return $this->file;
    }
}
