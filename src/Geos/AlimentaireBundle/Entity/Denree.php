<?php
namespace Geos\AlimentaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author SAM Patindsaongo Robert
 * @ORM\Entity
 */

class Denree {
	
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
	 * @var string categorie
	 * @ORM\Column(type="string")
	 */
	protected $categorie;


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
     * Set categorie
     *
     * @param string $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * Get categorie
     *
     * @return string 
     */
    public function getCategorie()
    {
        return $this->categorie;
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
    
    public function __toString() {
    	return $this->libelle;
    }
}