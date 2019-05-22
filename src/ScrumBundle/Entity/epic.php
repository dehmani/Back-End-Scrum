<?php

namespace ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * epic
 *
 * @ORM\Table(name="epic")
 * @ORM\Entity(repositoryClass="ScrumBundle\Repository\epicRepository")
 */
class epic
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
     * @ORM\ManyToOne(targetEntity="ScrumBundle\Entity\projet")
     * @ORM\JoinColumn(name="id_projet",referencedColumnName="id",onDelete="cascade")
     */

    private $projet;


    /**
     * @var string
     *
     * @ORM\Column(name="nom_epic", type="string", length=255)
     */
    private $nomEpic;

    /**
     * @var string
     *
     * @ORM\Column(name="description_epic", type="string", length=255)
     */
    private $descriptionEpic;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



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
     * Set nomEpic
     *
     * @param string $nomEpic
     *
     * @return epic
     */
    public function setNomEpic($nomEpic)
    {
        $this->nomEpic = $nomEpic;

        return $this;
    }

    /**
     * Get nomEpic
     *
     * @return string
     */
    public function getNomEpic()
    {
        return $this->nomEpic;
    }

    /**
     * Set descriptionEpic
     *
     * @param string $descriptionEpic
     *
     * @return epic
     */
    public function setDescriptionEpic($descriptionEpic)
    {
        $this->descriptionEpic = $descriptionEpic;

        return $this;
    }

    /**
     * Get descriptionEpic
     *
     * @return string
     */
    public function getDescriptionEpic()
    {
        return $this->descriptionEpic;
    }

    /**
     * Get projet
     *
     * @return projet
     */
    public function getrojet()
    {
        return $this->projet;
    }

    /**
     * Set projet
     *
     * @param projet $projet
     *
     * @return epic
     */

    public function setProjet(projet $projet)
    {
        $this->projet = $projet;
        return $this;
    }





}

