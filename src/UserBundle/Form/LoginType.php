<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/29/2017
 * Time: 9:13 PM
 */

namespace UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class LoginType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('_username', TextType::class, [
			'label'=>'Username',
			'required'=>true,
			'constraints' => [
				new Length(['min'=>6, 'max'=>64])
			],
			'attr' => [
				'class' => 'form-control'
			],
			'data' => $options['last_username']
			])
			->add('_password', PasswordType::class, [
				'required'=>true,
				'label'=>'Password',
				'constraints' => [
					new Length(['min'=>6, 'max'=>32])
				],
				'attr' => [
					'class' => 'form-control'
				]
			])
			->add('_target_path', HiddenType::class, [
				'data'=>'homepage'
			])

		;
	}


	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'last_username' => null,
			'action' => '/login',
			'csrf_field_name'=>'_csrf_token'
		]);
	}


	public function getBlockPrefix()
	{
		return '';
	}
}