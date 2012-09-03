<?php
namespace Geos\EauBundle\Entity;
use Geos\GeoEntityBundle\Entity\Poi,
	Geos\GeoEntityBundle\Entity\Zoi,
	Doctrine\ORM\Mapping as ORM,
	Geos\GeoEntityBundle\Lib\Point;

/**
 * @author Patindsaongo SAM
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Geos\EauBundle\Repository\PointEauRepository")
 */

class PointEau extends Poi {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var string peType
	 * @ORM\Column(type="string")
	 */
	protected $peType;
	
	/**
	 * @var date dateMes
	 * @ORM\Column(type="date", nullable=true)
	 */
	
	protected $dateMes;
    /**
     * @var geometry $geometrie
     */
    protected $geometrie;

    /**
     * @var Geos\EauBundle\Entity\Zoi
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
     * Set peType
     *
     * @param string $peType
     */
    public function setPeType($peType)
    {
        $this->peType = $peType;
    }

    /**
     * Get peType
     *
     * @return string 
     */
    public function getPeType()
    {
        return $this->peType;
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
    
    public function __toString(){
    	return $this->peType;
    }

    /**
     * Set dateMes
     *
     * @param date $dateMes
     */
    public function setDateMes($dateMes)
    {
        $this->dateMes = $dateMes;
    }

    /**
     * Get dateMes
     *
     * @return date 
     */
    public function getDateMes()
    {
        return $this->dateMes;
    }
    /**
     * @var string $status
     */
    protected  $status;


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
}