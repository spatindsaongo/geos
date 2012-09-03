<?php

namespace Geos\AlimentaireBundle\Form;

use Symfony\Component\Validator\Constraints\Choice;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PrixType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('valeur')
            ->add('dateValeur')
            ->add('uniteMesure','choice',array('choices'=>array('kg'=>"kg",
            													'litre'=>'litre',
            													'unité'=>"unité")))
            ->add('marche')
            ->add('denree')
        ;
    }

    public function getName()
    {
        return 'geos_alimentairebundle_prixtype';
    }
}
