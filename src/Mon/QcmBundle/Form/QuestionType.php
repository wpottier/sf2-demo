<?php

namespace Mon\QcmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sentence')
            ->add('explanation')
            ->add('propositions', 'collection', [
                'type' => new AnswerPropositionType(),
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'horizontal' => false,
                'options' => array(
                    'label_render' => false,
                    'horizontal' => true,
                    'horizontal_input_wrapper_class' => "col-lg-8",
                )
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mon\QcmBundle\Entity\Question'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mon_qcmbundle_question';
    }
}
