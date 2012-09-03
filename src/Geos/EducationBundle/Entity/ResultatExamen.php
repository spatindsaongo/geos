<?php
namespace Geos\EducationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @author spatindsaongo
 * @ORM\Entity
 * 
 */
class ResultatExamen {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var string libelle
	 * @ORM\Column(type="string", length="100")
	 */
	protected $libelle;
	
	/**
	 * @var string effectifMasculin
	 * @ORM\Column(type="integer")
	 */
	protected $admisFeminin;
	
	/**
	 * @var string effectifMasculin
	 * @ORM\Column(type="integer")
	 */
	protected $admisMasculin;
	
    /**
     * @ORM\OneToOne(targetEntity="Classe", inversedBy="resultatExamen")
     * @ORM\JoinColumn(name="classe_id", referencedColumnName="id")
     **/
	
	protected $classe;


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
     * Set admisFeminin
     *
     * @param integer $admisFeminin
     */
    public function setAdmisFeminin($admisFeminin)
    {
        $this->admisFeminin = $admisFeminin;
    }

    /**
     * Get admisFeminin
     *
     * @return integer 
     */
    public function getAdmisFeminin()
    {
        return $this->admisFeminin;
    }

    /**
     * Set admisMasculin
     *
     * @param integer $admisMasculin
     */
    public function setAdmisMasculin($admisMasculin)
    {
        $this->admisMasculin = $admisMasculin;
    }

    /**
     * Get admisMasculin
     *
     * @return integer 
     */
    public function getAdmisMasculin()
    {
        return $this->admisMasculin;
    }

    /**
     * Set classe
     *
     * @param Geos\EducationBundle\Entity\Classe $classe
     */
    public function setClasse(\Geos\EducationBundle\Entity\Classe $classe)
    {
        $this->classe = $classe;
    }

    /**
     * Get classe
     *
     * @return Geos\EducationBundle\Entity\Classe 
     */
    public function getClasse()
    {
        return $this->classe;
    }
    
    public function __toString()
    {
    	return $this->libelle;
    }
}