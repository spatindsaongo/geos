<?php
namespace Geos\GeoEntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
	Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Patindsaongo SAM
 * @ORM\Entity
 */

class Region extends Zoi {

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
	 * @var Commune chefLieu
	 * @ORM\OneToOne(targetEntity="Commune")
	 * @ORM\JoinColumn(name="cheflieu_id", referencedColumnName="id")
	 */
	protected $chefLieu;
	
	/**
	 * @var Province provinces
	 * @ORM\OneToMany(targetEntity="Province", mappedBy="region")
	 */
	protected $provinces;


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
        $this->provinces = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set chefLieu
     *
     * @param Geos\GeoEntityBundle\Entity\Commune $chefLieu
     */
    public function setChefLieu(\Geos\GeoEntityBundle\Entity\Commune $chefLieu)
    {
        $this->chefLieu = $chefLieu;
    }

    /**
     * Get chefLieu
     *
     * @return Geos\GeoEntityBundle\Entity\Commune 
     */
    public function getChefLieu()
    {
        return $this->chefLieu;
    }

    /**
     * Add provinces
     *
     * @param Geos\GeoEntityBundle\Entity\Province $provinces
     */
    public function addProvince(\Geos\GeoEntityBundle\Entity\Province $provinces)
    {
        $this->provinces[] = $provinces;
    }

    /**
     * Get provinces
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProvinces()
    {
        return $this->provinces;
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
    	
    	return $this->nom.'';
    }
}