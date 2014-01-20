<?php
/**
 * Created by PhpStorm.
 * User: KAN
 * Date: 22.01.14
 * Time: 2:25
 */

namespace Kan\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->add('created', 'date')
            ->add('edited', 'date', array('widget' => 'single_text'))
//            ->add('notMappedField', 'text', array('mapped' => false))
            ->add('save', 'submit');
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'page';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                 'data_class' => 'Kan\CmsBundle\Entity\Page',
            )
        );
    }
}