<?php

namespace Geos\EducationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ClasseType extends AbstractType
{
	private  function getAcademicYears(){
		
		$year = 2000;
		$currentYear = getdate();
		$currentYear = $currentYear['year'];
		while ($year <= $currentYear){
			$academic = $year." - ".($year+1);
			$academicYear[$academic] = $academic;
			$year++;
		}
		return $academicYear;
	}
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('niveau')
            ->add('effectifFeminin')
            ->add('effectifMasculin')
            ->add('anneeScolaire','choice',array('choices'=> $this->getAcademicYears(),
            									 'required'=>true))
            ->add('centreFormation')
            ->add('resultatExamen')
        ;
    }

    public function getName()
    {
        return 'geos_educationbundle_classetype';
    }
}
