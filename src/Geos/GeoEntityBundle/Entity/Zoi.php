<?php
namespace Geos\GeoEntityBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Patindsaongo SAM
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type",type="string")
 * @ORM\DiscriminatorMap({"region"="Region","province"="Province","commune"="Commune","section"="Section","lot"="Lot","parcelle"="Parcelle"})
 */

class Zoi {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var pois
	 * @ORM\OneToMany(targetEntity="Poi", mappedBy="zoi")
	 */
	protected $pois;
	
	/**
	 * @ORM\Column(type="geometry", nullable=true)
	 */
	protected $geometrie;
	
	public function __construct(){
		$this->pois = new ArrayCollection();
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
}