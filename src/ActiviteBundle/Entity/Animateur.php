<?php

namespace ActiviteBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Animateur
 *
 * @ORM\Table(name="animateur")
 * @ORM\Entity(repositoryClass="ActiviteBundle\Repository\AnimateurRepository")
 */
class Animateur
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
     * @var string
     *@Assert\File(maxSize="500k", mimeTypes={"image/jpeg", "image/jpg", "image/png", "image/GIF"})
     * @ORM\Column(name="Photo", type="string", length=255)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="nomAnimateur", type="string", length=255)
     */
    private $nomAnimateur;

    /**
     * @var int
     *
     * @ORM\Column(name="cinAnimateur", type="integer")
     */
    private $cinAnimateur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="datetime")
     */
    private $dateNaissance;


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
     * @return Animateur
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
     * Set nomAnimateur
     *
     * @param string $nomAnimateur
     *
     * @return Animateur
     */
    public function setNomAnimateur($nomAnimateur)
    {
        $this->nomAnimateur = $nomAnimateur;

        return $this;
    }

    /**
     * Get nomAnimateur
     *
     * @return string
     */
    public function getNomAnimateur()
    {
        return $this->nomAnimateur;
    }

    /**
     * Set cinAnimateur
     *
     * @param integer $cinAnimateur
     *
     * @return Animateur
     */
    public function setCinAnimateur($cinAnimateur)
    {
        $this->cinAnimateur = $cinAnimateur;

        return $this;
    }

    /**
     * Get cinAnimateur
     *
     * @return int
     */
    public function getCinAnimateur()
    {
        return $this->cinAnimateur;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Animateur
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }
}

