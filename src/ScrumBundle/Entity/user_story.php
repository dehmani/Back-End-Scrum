<?php

namespace ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * user_story
 *
 * @ORM\Table(name="user_story")
 * @ORM\Entity(repositoryClass="ScrumBundle\Repository\user_storyRepository")
 */
class user_story
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
     * @ORM\ManyToOne(targetEntity="ScrumBundle\Entity\epic")
     * @ORM\JoinColumn(name="id_epic",referencedColumnName="id",onDelete="cascade")
     */

    private $epic;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_ser_story", type="string", length=255)
     */
    private $nomSerStory;

    /**
     * @var string
     *
     * @ORM\Column(name="description_user_story", type="string", length=255)
     */
    private $descriptionUserStory;

    /**
     * @var int
     *
     * @ORM\Column(name="business_value", type="integer")
     */
    private $businessValue;

    /**
     * @var int
     *
     * @ORM\Column(name="point_comp", type="integer")
     */
    private $pointComp;

    /** @ORM\Column(name="statut", type="string", columnDefinition="ENUM('new','todo','ongoing','done')") */

    private $statut;

    /** @ORM\Column(name="priorite", type="string", columnDefinition="ENUM('normale','haute','basse','urgente')", options={"default":"normale"}) */

    private $priorite;


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
     * Set nomSerStory
     *
     * @param string $nomSerStory
     *
     * @return user_story
     */
    public function setNomSerStory($nomSerStory)
    {
        $this->nomSerStory = $nomSerStory;

        return $this;
    }

    /**
     * Get nomSerStory
     *
     * @return string
     */
    public function getNomSerStory()
    {
        return $this->nomSerStory;
    }

    /**
     * Set descriptionUserStory
     *
     * @param string $descriptionUserStory
     *
     * @return user_story
     */
    public function setDescriptionUserStory($descriptionUserStory)
    {
        $this->descriptionUserStory = $descriptionUserStory;

        return $this;
    }

    /**
     * Get descriptionUserStory
     *
     * @return string
     */
    public function getDescriptionUserStory()
    {
        return $this->descriptionUserStory;
    }

    /**
     * Set businessValue
     *
     * @param integer $businessValue
     *
     * @return user_story
     */
    public function setBusinessValue($businessValue)
    {
        $this->businessValue = $businessValue;

        return $this;
    }

    /**
     * Get businessValue
     *
     * @return int
     */
    public function getBusinessValue()
    {
        return $this->businessValue;
    }

    /**
     * Set pointComp
     *
     * @param integer $pointComp
     *
     * @return user_story
     */
    public function setPointComp($pointComp)
    {
        $this->pointComp = $pointComp;

        return $this;
    }

    /**
     * Get pointComp
     *
     * @return int
     */
    public function getPointComp()
    {
        return $this->pointComp;
    }



    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param mixed $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    /**
     * @return mixed
     */
    public function getPriorite()
    {
        return $this->priorite;
    }

    /**
     * @param mixed $priorite
     */
    public function setPriorite($priorite)
    {
        $this->priorite = $priorite;
    }

    /**
     * Get epic
     *
     * @return epic
     */
    public function getEpic()
    {
        return $this->epic;
    }
    /**
     * Set epic
     *
     * @param epic $epic
     *
     * @return epic
     */


    public function setEpic(epic $epic)
    {
        $this->epic = $epic;
        return $this;
    }


}

