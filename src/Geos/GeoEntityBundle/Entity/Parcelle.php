<?php
namespace Geos\GeoEntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @author Patindsaongo SAM
 * @ORM\Entity
 */

class Parcelle extends Zoi {
	
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
	 * @var Lot lot
	 * @ORM\ManyToOne(targetEntity="Lot", inversedBy ="parcelles")
	 * @ORM\JoinColumn(name="lot_id", referencedColumnName="id")
	 */
	protected $lot;

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
     * Set lot
     *
     * @param Geos\GeoEntityBundle\Entity\Lot $lot
     */
    public function setLot(\Geos\GeoEntityBundle\Entity\Lot $lot)
    {
        $this->lot = $lot;
    }

    /**
     * Get lot
     *
     * @return Geos\GeoEntityBundle\Entity\Lot 
     */
    public function getLot()
    {
        return $this->lot;
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