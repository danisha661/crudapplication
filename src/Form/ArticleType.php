<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\EventListener\AddEmailFieldListener;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'attr' => array("class" => "form-control")
            ))->add('body', TextareaType::class, array(
                "attr" => array("class" => "form-control")
            ))->add('firstname', TextType::class, array(
                "attr" => array("class" => "form-control"),
                'constraints' => [new Length(['min' => 3])],

            ))->add('lastname', TextType::class, array(
                "attr" => array("class" => "form-control")
            ))->add('username', TextType::class, array(
                "attr" => array("class" => "form-control")
            ))->add('email', TextType::class, array(
                "attr" => array("class" => "form-control")
            ))->add('save', SubmitType::class, array(
                "label" => "Create",
                "attr" => array("class" => "btn btn-primary")
            ))->addEventSubscriber(new AddEmailFieldListener());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
