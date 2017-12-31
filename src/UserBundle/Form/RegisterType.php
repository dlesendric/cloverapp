<?php

namespace UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('firstName', TextType::class, array(
				'attr' => array('class'=>'form-control')
			))
			->add('lastName', TextType::class, array(
				'attr' => array('class'=>'form-control')
			))
			->add('username', TextType::class, array(
				'attr' => array('class'=>'form-control')
			))
			->add('password', RepeatedType::class, array(
				'type' => PasswordType::class,
				'invalid_message' => 'The password fields must match.',
				'options' => array('attr' => array('class' => 'form-control')),
				'required' => true,
				'first_options'  => array('label' => 'Password'),
				'second_options' => array('label' => 'Repeat Password'),
			));
	}


	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => 'UserBundle\Entity\User'
		]);
	}


	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'register';
	}
}