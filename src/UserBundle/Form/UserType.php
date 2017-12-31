<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Security;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('firstName', TextType::class, [
	        	'label' => 'First Name',
		        'attr' => array('class'=>'form-control')
	        ])
	        ->add('lastName',  TextType::class, [
			    'label' => 'Last Name',
			    'attr' => array('class'=>'form-control')
            ])
	        ->add('username', TextType::class, [
		        'label' => 'Username',
		        'attr' => array('class'=>'form-control')
	        ])
	        ->add('password', PasswordType::class, [
		        'label' => 'Password',
		        'attr' => array('class'=>'form-control'),
		        'required' => false
	        ])
	        ->add('enabled')
	        ->add('roles', ChoiceType::class, [
	        	'attr' => array('class'=>'selectpicker'),
		        'choices'=>$options['roles'],
		        'multiple' => true
	        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User',
	        'roles' => array()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_user';
    }


}
