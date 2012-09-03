<?php
namespace Geos\AssainissementBundle\Entity;

use Geos\GeoEntityBundle\Entity\Poi,
	Doctrine\ORM\Mapping as ORM,
	Geos\GeoEntityBundle\Entity\Zoi;

/**
 * 
 * @author Patindsaongo Robert SAM
 * @ORM\Entity
 */
class OuvAutonome extends Poi{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var string ouvType
	 * @ORM\Column(type="string")
	 */
	protected $ouvType;
	
	/**
	 * @var string utility
	 * @ORM\Column(type="string")
	 */
	protected $utility;
	
	/**
	 * @var integer nbrePoste
	 * @ORM\Column(type="integer")
	 */	
	protected $nbrePoste;
	
	/**
	 * @var date dateMes
	 * @ORM\Column(type="date", nullable=true)
	 */
	
	protected $dateMes;
	

    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var geometry $geometrie
     */
    protected $geometrie;

    /**
     * @var Geos\AssainissementBundle\Entity\Zoi
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
     * Set ouvType
     *
     * @param string $ouvType
     */
    public function setOuvType($ouvType)
    {
        $this->ouvType = $ouvType;
    }

    /**
     * Get ouvType
     *
     * @return string 
     */
    public function getOuvType()
    {
        return $this->ouvType;
    }

    /**
     * Set utility
     *
     * @param string $utility
     */
    public function setUtility($utility)
    {
        $this->utility = $utility;
    }

    /**
     * Get utility
     *
     * @return string 
     */
    public function getUtility()
    {
        return $this->utility;
    }

    /**
     * Set nbrePoste
     *
     * @param integer $nbrePoste
     */
    public function setNbrePoste($nbrePoste)
    {
        $this->nbrePoste = $nbrePoste;
    }

    /**
     * Get nbrePoste
     *
     * @return integer 
     */
    public function getNbrePoste()
    {
        return $this->nbrePoste;
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
}