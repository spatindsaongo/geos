<?php
namespace Geos\SanteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author SAM Patindsaongo Robert
 * @ORM\Entity
 */

class Agent {
	
	/**
	 * @var integer id
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var string libelle
	 * @ORM\Column(type="string")
	 */
	protected $libelle;
	
	/**
	 * @var integer nombre
	 *  @ORM\Column(type="integer")
	 */
	protected $nombre;
	
	/**
	 * @var 
	 * @ORM\ManyToOne(targetEntity="CentreSante", inversedBy="agents")
	 * @ORM\JoinColumn(name="centreSante_id", referencedColumnName="id")
	 */
	protected $centreSante;


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
     * Set libelle
     *
     * @param string $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set nombre
     *
     * @param integer $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return integer 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set centreSante
     *
     * @param Geos\SanteBundle\Entity\CentreSante $centreSante
     */
    public function setCentreSante(\Geos\SanteBundle\Entity\CentreSante $centreSante)
    {
        $this->centreSante = $centreSante;
    }

    /**
     * Get centreSante
     *
     * @return Geos\SanteBundle\Entity\CentreSante 
     */
    public function getCentreSante()
    {
        return $this->centreSante;
    }
    
    public function __toString(){
    	return $this->nom;
    }
}