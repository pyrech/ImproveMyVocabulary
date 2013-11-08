<?php

namespace Imv\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WordType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('details')
            ->add('translations', 'collection', array(
                'type' => new TranslationType(),
                'allow_add' => true,
                'by_reference' => false
            ))
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Imv\CoreBundle\Entity\Word',
            'cascade_validation' => true
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'imv_corebundle_word';
    }
}
