<?php
namespace Geos\AlimentaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author SAM Patindsaongo Robert
 * @ORM\Entity
 */


class Prix {
	
	/**
	 * @var integer id
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	protected $id;
	
	
	/**
	 * @var float valeur
	 * @ORM\Column(type="float")
	 */
	protected $valeur;
	
	/**
	 * @var string uniteMesure
	 * @ORM\Column(type="string")
	 */
	protected $uniteMesure;
	
	/**
	 * @var \DateTime dateValeur
	 * @ORM\Column(type="datetime")
	 */
	protected $dateValeur;
	
	
	/**
	 * @ORM\ManyToOne(targetEntity="Marche")
	 * @ORM\JoinColumn(name="marche_id", referencedColumnName="id")
	 **/
	protected $marche;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Denree")
	 * @ORM\JoinColumn(name="denree_id", referencedColumnName="id")
	 **/
	protected $denree;


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
     * Set valeur
     *
     * @param float $valeur
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;
    }

    /**
     * Get valeur
     *
     * @return float 
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set dateValeur
     *
     * @param datetime $dateValeur
     */
    public function setDateValeur($dateValeur)
    {
        $this->dateValeur = $dateValeur;
    }

    /**
     * Get dateValeur
     *
     * @return datetime 
     */
    public function getDateValeur()
    {
        return $this->dateValeur;
    }

    /**
     * Set marche
     *
     * @param Geos\AlimentaireBundle\Entity\Marche $marche
     */
    public function setMarche(\Geos\AlimentaireBundle\Entity\Marche $marche)
    {
        $this->marche = $marche;
    }

    /**
     * Get marche
     *
     * @return Geos\AlimentaireBundle\Entity\Marche 
     */
    public function getMarche()
    {
        return $this->marche;
    }

    /**
     * Set denree
     *
     * @param Geos\AlimentaireBundle\Entity\Denree $denree
     */
    public function setDenree(\Geos\AlimentaireBundle\Entity\Denree $denree)
    {
        $this->denree = $denree;
    }

    /**
     * Get denree
     *
     * @return Geos\AlimentaireBundle\Entity\Denree 
     */
    public function getDenree()
    {
        return $this->denree;
    }

    /**
     * Set uniteMesure
     *
     * @param string $uniteMesure
     */
    public function setUniteMesure($uniteMesure)
    {
        $this->uniteMesure = $uniteMesure;
    }

    /**
     * Get uniteMesure
     *
     * @return string 
     */
    public function getUniteMesure()
    {
        return $this->uniteMesure;
    }
}