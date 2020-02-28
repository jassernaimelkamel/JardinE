<?php

namespace ActiviteBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activite
 *
 * @ORM\Table(name="activite")
 * @ORM\Entity(repositoryClass="ActiviteBundle\Repository\ActiviteRepository")
 */
class Activite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *@ORM\ManyToOne(targetEntity="Animateur")
     *@ORM\JoinColumn(referencedColumnName="id")
     */
    private $animateur;

    /**
     *@ORM\ManyToOne(targetEntity="categorie")
     *@ORM\JoinColumn(referencedColumnName="id")
     */
    private $categorie;

    /**
     * @var string
     *@Assert\File(maxSize="500k", mimeTypes={"image/jpeg", "image/jpg", "image/png", "image/GIF"})
     * @ORM\Column(name="Photo", type="string", length=255)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="nomActivite", type="string", length=255)
     */
    private $nomActivite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateActivite", type="datetime")
     */
    private $dateActivite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeStart", type="time")
     */
    private $timeStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeEnd", type="time")
     */
    private $timeEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Activite
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set nomActivite
     *
     * @param string $nomActivite
     *
     * @return Activite
     */
    public function setNomActivite($nomActivite)
    {
        $this->nomActivite = $nomActivite;

        return $this;
    }

    /**
     * Get nomActivite
     *
     * @return string
     */
    public function getNomActivite()
    {
        return $this->nomActivite;
    }

    /**
     * Set dateActivite
     *
     * @param \DateTime $dateActivite
     *
     * @return Activite
     */
    public function setDateActivite($dateActivite)
    {
        $this->dateActivite = $dateActivite;

        return $this;
    }

    /**
     * Get dateActivite
     *
     * @return \DateTime
     */
    public function getDateActivite()
    {
        return $this->dateActivite;
    }

    /**
     * Set timeStart
     *
     * @param string $timeStart
     *
     * @return Activite
     */
    public function setTimeStart($timeStart)
    {
        $this->timeStart = $timeStart;

        return $this;
    }

    /**
     * Set timeStart
     *
     * @return Activite
     */
    public function getTimeStart()
    {
        return $this->timeStart;
    }

    /**
     * Set timeEnd
     *
     * @param \DateTime $timeEnd
     *
     * @return Activite
     */
    public function setTimeEnd($timeEnd)
    {
        $this->timeEnd = $timeEnd;

        return $this;
    }

    /**
     * Get timeEnd
     *
     * @return \DateTime
     */
    public function getTimeEnd()
    {
        return $this->timeEnd;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Activite
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getAnimateur()
    {
        return $this->animateur;
    }

    /**
     * @param mixed $animateur
     */
    public function setAnimateur($animateur)
    {
        $this->animateur = $animateur;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }
}

