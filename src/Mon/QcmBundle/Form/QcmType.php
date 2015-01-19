<?php

namespace Mon\QcmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QcmType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('questions', 'collection', [
                'type' => new QuestionType(),
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mon\QcmBundle\Entity\Qcm'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mon_qcmbundle_qcm';
    }
}
