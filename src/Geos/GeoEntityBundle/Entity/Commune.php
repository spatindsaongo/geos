<?php
namespace Geos\GeoEntityBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
/** 
 * @author Patindsaongo SAM 
 * @ORM\Entity
 */

class Commune extends Zoi {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */

	protected $id;
	
	/**
	 * @var string nom
	 * @ORM\Column(type="string", unique=true, length="100")
	 */
	protected $nom;
	
	/**
	 * @var string status
	 * @ORM\Column(type="string", length="100")
	 */
	protected $status;
	
	/**
	 * @var Province province
	 * @ORM\ManyToOne(targetEntity="Province", inversedBy ="communes")
	 * @ORM\JoinColumn(name="province_id", referencedColumnName="id")
	 */
	protected $province;
	
	/**
	 * @var Section sections
	 * @ORM\OneToMany(targetEntity="Section", mappedBy="commune")
	 */
	protected $sections;
	

    /**
     * @var geometry $geometrie
     */
    protected $geometrie;

    /**
     * @var Geos\GeoEntityBundle\Entity\Poi
     */
    protected $pois;

    public function __construct()
    {
        $this->pois = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sections = new ArrayCollection();
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
     * Add pois
     *
     * @param Geos\GeoEntityBundle\Entity\Poi $pois
     */
    public function addPoi(\Geos\GeoEntityBundle\Entity\Poi $pois)
    {
        $this->pois[] = $pois;
    }

    /**
     * Get pois
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPois()
    {
        return $this->pois;
    }
    
    public function __toString(){
    	return ''.$this->nom;
    }

    /**
     * Set province
     *
     * @param Geos\GeoEntityBundle\Entity\Province $province
     */
    public function setProvince(\Geos\GeoEntityBundle\Entity\Province $province)
    {
        $this->province = $province;
    }

    /**
     * Get province
     *
     * @return Geos\GeoEntityBundle\Entity\Province 
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Add sections
     *
     * @param Geos\GeoEntityBundle\Entity\Section $sections
     */
    public function addSection(\Geos\GeoEntityBundle\Entity\Section $sections)
    {
        $this->sections[] = $sections;
    }

    /**
     * Get sections
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSections()
    {
        return $this->sections;
    }
}