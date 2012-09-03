<?php

namespace Geos\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
            //->add('usernameCanonical')
            ->add('email')
            //->add('emailCanonical')
            //->add('enabled')
            //->add('salt')
            ->add('password')
           // ->add('lastLogin')
            //->add('locked')
            //->add('expired')
            //->add('expiresAt')
            //->add('confirmationToken')
            //->add('passwordRequestedAt')
            //->add('roles')
            //->add('credentialsExpired')
            //->add('credentialsExpireAt')
        ;
    }

    public function getName()
    {
        return 'geos_userbundle_utilisateurtype';
    }
}
