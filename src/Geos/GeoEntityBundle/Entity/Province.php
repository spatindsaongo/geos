<?php
namespace Geos\GeoEntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @author Patindsaongo SAM
 * @ORM\Entity
 */

class Province extends Zoi{
	
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
	 * @var Region region
	 * @ORM\ManyToOne(targetEntity="Region", inversedBy ="provinces")
	 * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
	 */
	protected $region;
	
	/**
	 * @var Commune communes
	 * @ORM\OneToMany(targetEntity="Commune", mappedBy="province")
	 */
	protected $communes;

    /**
     * @var geometry geometrie
     */
    protected $geometrie;

    /**
     * @var Geos\GeoEntityBundle\Entity\Poi
     */
    protected $pois;

    public function __construct()
    {
        $this->communes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set region
     *
     * @param Geos\GeoEntityBundle\Entity\Region $region
     */
    public function setRegion(\Geos\GeoEntityBundle\Entity\Region $region)
    {
        $this->region = $region;
    }

    /**
     * Get region
     *
     * @return Geos\GeoEntityBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Add communes
     *
     * @param Geos\GeoEntityBundle\Entity\Commune $communes
     */
    public function addCommune(\Geos\GeoEntityBundle\Entity\Commune $communes)
    {
        $this->communes[] = $communes;
    }

    /**
     * Get communes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCommunes()
    {
        return $this->communes;
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
}