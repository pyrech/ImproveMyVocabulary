<?php

namespace Imv\CoreBundle\Form;

use Imv\CoreBundle\Entity\WordList;
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
            ->add('wordlists', 'entity', array(
                'multiple'  => true,
                'expanded' => true,
                'property' => 'name',
                'class'  => 'Imv\CoreBundle\Entity\WordList',
                'by_reference' => false
            ))
            ->add('translations', 'collection', array(
                'type' => new TranslationType(),
                'allow_add' => true,
                'allow_delete' => true,
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
