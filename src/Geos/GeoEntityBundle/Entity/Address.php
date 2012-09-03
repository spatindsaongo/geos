<?php
namespace Geos\GeoEntityBundle\Entity;
use Geos\GeoEntityBundle\Entity\Poi;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class Address extends Poi {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	
	protected $id;
	
	/**
	 * @var string nom
	 * @ORM\Column(type="string", length="100")
	 */
	protected $nom;
    /**
     * @var geometry $geometrie
     */
    protected $geometrie;

    /**
     * @var Geos\GeoEntityBundle\Entity\Zoi
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