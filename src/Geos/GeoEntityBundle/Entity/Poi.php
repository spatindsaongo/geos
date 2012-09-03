<?php
namespace Geos\GeoEntityBundle\Entity;


use Doctrine\ORM\Mapping as ORM,
	Geos\GeoEntityBundle\Lib\Point;

/**
 * @author Patindsaongo SAM
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type",type="string")
 * @ORM\DiscriminatorMap({"pointeau"="Geos\EauBundle\Entity\PointEau", "adress"="Address", "ouvautonome"="Geos\AssainissementBundle\Entity\OuvAutonome", "centreformation"="Geos\EducationBundle\Entity\CentreFormation", "marche"="Geos\AlimentaireBundle\Entity\Marche", "centresante"="Geos\SanteBundle\Entity\CentreSante"})
 */

class Poi {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var unknown_type
	 * @ORM\ManyToOne(targetEntity="Zoi", inversedBy="pois")
	 * @ORM\JoinColumn(name="zoi_id", referencedColumnName="id")
	 */
	
	protected $zoi;
	
	/**
	 * @var string status
	 * @ORM\Column(type="string", length="10", nullable=true)
	 */
	protected $status;
	
	/**
	 * @ORM\Column(type="geometry", nullable=true)
	 */
	protected $geometrie;
 

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