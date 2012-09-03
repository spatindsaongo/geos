<?php
namespace Geos\GeoEntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @author Patindsaongo SAM
 * @ORM\Entity
 */

class Section extends Zoi {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var string nom
	 * @ORM\Column(type="string", length="30")
	 */
	protected $numero;
	
	/**
	 * @var Commune commune
	 * @ORM\ManyToOne(targetEntity="Commune", inversedBy ="Sections")
	 * @ORM\JoinColumn(name="commune_id", referencedColumnName="id")
	 */
	protected $commune;
	
	/**
	 * @var Section sections
	 * @ORM\OneToMany(targetEntity="Lot", mappedBy="section")
	 */
	protected $lots;
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
        $this->lots = new \Doctrine\Common\Collections\ArrayCollection();
    $this->pois = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set numero
     *
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
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
     * Set commune
     *
     * @param Geos\GeoEntityBundle\Entity\Commune $commune
     */
    public function setCommune(\Geos\GeoEntityBundle\Entity\Commune $commune)
    {
        $this->commune = $commune;
    }

    /**
     * Get commune
     *
     * @return Geos\GeoEntityBundle\Entity\Commune 
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * Add lots
     *
     * @param Geos\GeoEntityBundle\Entity\Lot $lots
     */
    public function addLot(\Geos\GeoEntityBundle\Entity\Lot $lots)
    {
        $this->lots[] = $lots;
    }

    /**
     * Get lots
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLots()
    {
        return $this->lots;
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
    	 
    	return "".$this->numero;
    }
}