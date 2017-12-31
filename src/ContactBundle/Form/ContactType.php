<?php

namespace ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('line', TextType::class, [
	        	'attr' => array('class'=>'form-control')

	        ])
	        ->add('phone', TelType::class, [
	        	'attr' => array('class' => 'form-control')
	        ])
	        ->add('city', TextType::class, [
	        	'attr' => array('class'=>'form-control')
	        ])
	        ->add('state', CountryType::class, [
	        	'attr' => array('class' => 'selectpicker')
	        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ContactBundle\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'contactbundle_contact';
    }


}
