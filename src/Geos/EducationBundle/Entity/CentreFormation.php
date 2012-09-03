<?php
namespace Geos\EducationBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Geos\GeoEntityBundle\Entity\Poi,
	Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @author spatindsaongo
 * @ORM\Entity
 * 
 */

class CentreFormation extends Poi {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var string nom
	 * @ORM\Column(type="string")
	 */
	protected $nom;
	
	/**
	 * @var string type
	 * @ORM\Column(type="string", length="100")
	 */
	protected $cftype;
	
	/**
	 * @var string responsable
	 * @ORM\Column(type="string")
	 */
	protected $responsable;
	
	/**
	 * @var string creation
	 * @ORM\Column(type="date", nullable=true)
	 */
	protected $creation;
	
	/**
	 * @var string propriete
	 * @ORM\Column(type="string", length="100")
	 */
	protected $propriete;
	
	/**
	 * @var Classe classes
	 * @ORM\OneToMany(targetEntity="Classe", mappedBy="centreFormation")
	 */
	protected $classes;
	
	public function __construct(){
		$this->classes = new ArrayCollection();
	}

	
    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var geometry $geometrie
     */
    protected $geometrie;

    /**
     * @var Geos\EducationBundle\Entity\Zoi
     */
    protected $zoi;


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
     * Set nom
     *
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
    }

    /**
     * Get responsable
     *
     * @return string 
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set creation
     *
     * @param date $creation
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;
    }

    /**
     * Get creation
     *
     * @return date 
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * Set propriete
     *
     * @param string $propriete
     */
    public function setPropriete($propriete)
    {
        $this->propriete = $propriete;
    }

    /**
     * Get propriete
     *
     * @return string 
     */
    public function getPropriete()
    {
        return $this->propriete;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set geometrie
     *
     * @param geometry $geometrie
     */
    public function setGeometrie($geometrie)
    {
        $this->geometrie = $geometrie;
    }

    /**
     * Get geometrie
     *
     * @return geometry 
     */
    public function getGeometrie()
    {
        return $this->geometrie;
    }

    /**
     * Add classes
     *
     * @param Geos\EducationBundle\Entity\Classe $classes
     */
    public function addClasse(\Geos\EducationBundle\Entity\Classe $classes)
    {
        $this->classes[] = $classes;
    }

    /**
     * Get classes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Set zoi
     *
     * @param Geos\GeoEntityBundle\Entity\Zoi $zoi
     */
    public function setZoi(\Geos\GeoEntityBundle\Entity\Zoi $zoi)
    {
        $this->zoi = $zoi;
    }

    /**
     * Get zoi
     *
     * @return Geos\GeoEntityBundle\Entity\Zoi 
     */
    public function getZoi()
    {
        return $this->zoi;
    }

    /**
     * Set cftype
     *
     * @param string $cftype
     */
    public function setCftype($cftype)
    {
        $this->cftype = $cftype;
    }

    /**
     * Get cftype
     *
     * @return string 
     */
    public function getCftype()
    {
        return $this->cftype;
    }
    
    public function __toString(){
    	
    	return $this->nom;
    }
}