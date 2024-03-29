<?php

namespace Horus\BackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Horus\BackendBundle\Util\Box;
use Symfony\Component\Security\Core\Role\RoleInterface;


/**
 * @ORM\Table(name="groups")
 * @ORM\Entity
 */
class Group implements RoleInterface {


    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(name="role", type="string", length=20, unique=true)
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity="Administrateur", inversedBy="groups")
     */
    private $administrateurs;
    

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    // ... getters and setters for each property

    /**
     * @see RoleInterface
     */
    public function getRole()
    {
        return $this->role;
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
     * Set name
     *
     * @param string $name
     * @return Group
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

    /**
     * Set role
     *
     * @param string $role
     * @return Group
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Add administrateurs
     *
     * @param Horus\BackendBundle\Entity\Administrateur $administrateurs
     * @return Group
     */
    public function addAdministrateur(\Horus\BackendBundle\Entity\Administrateur $administrateurs)
    {
        $this->administrateurs[] = $administrateurs;
        return $this;
    }

    /**
     * Remove administrateurs
     *
     * @param Horus\BackendBundle\Entity\Administrateur $administrateurs
     */
    public function removeAdministrateur(\Horus\BackendBundle\Entity\Administrateur $administrateurs)
    {
        $this->administrateurs->removeElement($administrateurs);
    }

    /**
     * Get administrateurs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAdministrateurs()
    {
        return $this->administrateurs;
    }

    /**
     * Get name of Group
     * @return string
     */
    public function __toString(){
        return Box::limit_words($this->getName());
    }
}