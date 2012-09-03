<?php
namespace Geos\EducationBundle\Entity;

use Doctrine\DBAL\Types\IntegerType;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @author spatindsaongo
 * @ORM\Entity
 * 
 */

class Classe {
	
	/**
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
	 * @var string niveau
	 * @ORM\Column(type="string")
	 */
	protected $niveau;
	
	/**
	 * @var Integer effectifFeminin
	 * @ORM\Column(type="integer")
	 */
	protected $effectifFeminin;
	
	/**
	 * @var Integer effectifMasculin
	 * @ORM\Column(type="integer")
	 */	
	protected $effectifMasculin;
	
	/**
	 * @var string niveau
	 * @ORM\Column(type="string")
	 */
	protected $anneeScolaire;
	
	
	/**
	 * @var unknown_type
	 * @ORM\ManyToOne(targetEntity="CentreFormation", inversedBy="classes")
	 * @ORM\JoinColumn(name="centreFormation_id", referencedColumnName="id")
	 */	
	protected $centreFormation;
	
	/**
	 * @var ResultatExamen resultatExamen
	 *     
     * @ORM\OneToOne(targetEntity="ResultatExamen", mappedBy="classe")
     * 
	 */
	protected $resultatExamen;
	

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
     * Set niveau
     *
     * @param string $niveau
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;
    }

    /**
     * Get niveau
     *
     * @return string 
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set effectifFeminin
     *
     * @param integer $effectifFeminin
     */
    public function setEffectifFeminin($effectifFeminin)
    {
        $this->effectifFeminin = $effectifFeminin;
    }

    /**
     * Get effectifFeminin
     *
     * @return integer 
     */
    public function getEffectifFeminin()
    {
        return $this->effectifFeminin;
    }

    /**
     * Set effectifMasculin
     *
     * @param integer $effectifMasculin
     */
    public function setEffectifMasculin($effectifMasculin)
    {
        $this->effectifMasculin = $effectifMasculin;
    }

    /**
     * Get effectifMasculin
     *
     * @return integer 
     */
    public function getEffectifMasculin()
    {
        return $this->effectifMasculin;
    }

    /**
     * Set anneeScolaire
     *
     * @param string $anneeScolaire
     */
    public function setAnneeScolaire($anneeScolaire)
    {
        $this->anneeScolaire = $anneeScolaire;
    }

    /**
     * Get anneeScolaire
     *
     * @return string 
     */
    public function getAnneeScolaire()
    {
        return $this->anneeScolaire;
    }

    /**
     * Set centreFormation
     *
     * @param Geos\EducationBundle\Entity\CentreFormation $centreFormation
     */
    public function setCentreFormation(\Geos\EducationBundle\Entity\CentreFormation $centreFormation)
    {
        $this->centreFormation = $centreFormation;
    }

    /**
     * Get centreFormation
     *
     * @return Geos\EducationBundle\Entity\CentreFormation 
     */
    public function getCentreFormation()
    {
        return $this->centreFormation;
    }

    /**
     * Set resultatExamen
     *
     * @param Geos\EducationBundle\Entity\ResultatExamen $resultatExamen
     */
    public function setResultatExamen(\Geos\EducationBundle\Entity\ResultatExamen $resultatExamen)
    {
        $this->resultatExamen = $resultatExamen;
    }

    /**
     * Get resultatExamen
     *
     * @return Geos\EducationBundle\Entity\ResultatExamen 
     */
    public function getResultatExamen()
    {
        return $this->resultatExamen;
    }
    
    public function __toString(){
    	return $this->libelle;
    }
}