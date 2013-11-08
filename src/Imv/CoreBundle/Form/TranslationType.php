<?php

namespace Imv\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TranslationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('term')
            ->add('locale', 'entity', array(
                'class' => 'Imv\CoreBundle\Entity\Locale',
                'property' => 'name'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Imv\CoreBundle\Entity\Translation',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'imv_corebundle_translation';
    }
}
