<?php

namespace EP\UploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Files
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EP\UploadBundle\Entity\FilesRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Files
{
    /**
    * @ORM\ManyToOne(targetEntity="EP\UploadBundle\Entity\Category")
    * 
    */
    private $category;

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
     * @ORM\Column(name="ext", type="string", length=255)
     */
    private $ext;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
    * @ORM\Column(name="date", type="datetime")
    * @ORM\JoinColumn(nullable=false)
    */
    private $date;
    
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    private $file;

    // On ajoute cet attribut pour y stocker le nom du fichier temporairement
    private $tempFilename;


    public function __construct()
    {
        $this->date = new \Datetime();
    }

    public function getFile()
    {
    return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        // On vérifie si on avait déjà un fichier pour cette entité
        if (null !== $this->ext) {
          // On sauvegarde l'extension du fichier pour le supprimer plus tard
          $this->tempFilename = $this->ext;
          // On réinitialise les valeurs des attributs ext et name
          $this->ext = null;
          $this->name = null;
          $this->path = null;
        }
    }

    /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
    public function preUpload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif)
        if (null === $this->file) {
          return;
        }

        // Le nom du fichier est son id, on doit juste stocker également son extension
        $this->ext = $this->file->guessExtension();

        // Et on génère l'attribut name de la balise <img>, à la valeur du nom du fichier sur le PC de l'internaute
        $this->name = $this->file->getClientOriginalName();
        $this->path = $this->getUploadRootDir().'/'.$this->getId().'_'.$this->getName();

    }


    /**
    * @ORM\PostPersist()
    * @ORM\PostUpdate()
    */
    public function upload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif)
        if (null === $this->file) {
          return;
        }

        // Si on avait un ancien fichier, on le supprime
        if (null !== $this->tempFilename) {
          $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
          if (file_exists($oldFile)) {
            unlink($oldFile);
          }
        }

        // Je doit le réécrire ici car sinon l'id n'est pas pris en compte
        $this->path = $this->getUploadRootDir().'/'.$this->getId().'_'.$this->getName();

        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->file->move(
          $this->getUploadRootDir(), // Le répertoire de destination
          // $this->tempFilename
          $this->id.'_'.$this->name
          // $this->id.'.'.$this->ext   // Le nom du fichier à créer, ici « id.extension »
        );
    }

    /**
    * @ORM\PreRemove()
    */
    public function preRemoveUpload()
    {
        // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->getId().'_'.$this->getName();
    }

    /**
    * @ORM\PostRemove()
    */
    public function removeUpload()
        {
        // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
        if (file_exists($this->tempFilename)) {
          // On supprime le fichier
          unlink($this->tempFilename);
        }
    }

    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
        return '../uploads/img/'.$this->category->getName();
    }

    protected function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }


    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }


    /**
     * Set path
     *
     * @param string $path
     *
     * @return Files     
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

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
     * Set ext
     *
     * @param string $ext
     *
     * @return Files
     */
    public function setExt($ext)
    {
        $this->ext = $ext;

        return $this;
    }

    /**
     * Get ext
     *
     * @return string
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Files
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getWebPath()
    {
       return $this->getUploadDir().'/'.$this->getId().'_'.$this->getName();
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Files
     */
    public function setDate($date = null)
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
     * Set category
     *
     * @param \EP\UploadBundle\Entity\Category $category
     *
     * @return Files
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \EP\UploadBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
