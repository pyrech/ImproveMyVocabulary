<?php

namespace Imv\CoreBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Imv\CoreBundle\Entity\EntityInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


abstract class EntityController extends Controller
{
    const FORM_CREATE = 1;
    const FORM_EDIT   = 2;
    const FORM_DELETE = 3;

    /**
     * @var string
     */
    private $repositoryName;

    /**
     * Initialize the $repositoryName attribute
     */
    function __construct()
    {
        $this->repositoryName = $this->getRepositoryName();
    }

    /**
     * Returns the Doctrine Manager
     *
     * @return ObjectManager
     */
    protected function getManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * Returns the Entity repository
     *
     * @return \Imv\CoreBundle\Entity\WordRepository
     */
    protected function getRepository()
    {
        return $this->getManager()->getRepository($this->repositoryName);
    }

    /**
     * Returns repository's name of the related entity
     *
     * @return string
     */
    abstract protected function getRepositoryName();

    /**
     * Returns a Form type for the related entity
     *
     * @return \Symfony\Component\Form\AbstractType
     */
    abstract protected function getFormType();

    /**
     * Returns route name's prefix for the related entity
     * Eg: imv_{entity class name}
     *
     * @return string
     */
    abstract protected function getRouteNamePrefix();

    /**
     * Returns the full name of a route for the related entity
     *
     * @param string $action
     *
     * @return string
     */
    protected function getRouteName($action = '')
    {
        return $this->getRouteNamePrefix().($action ? '_'.$action : '');
    }

    /**
     * Returns a FormBuilder with a FormType depending on the type of form wanted
     *
     * Can be overridden to allow differents FormType for New or Edit forms
     * or to add behaviour in the FormBuilder before to create the form, for example.
     *
     * @param integer $type one of the self::FORM_XXX constant
     * @param EntityInterface $entity
     *
     * @return \Symfony\Component\Form\FormBuilderInterface
     *
     * @throws \LogicException if $type is not one of EntityController::FORM_XXX constants
     */
    protected function getFormBuilder($type, EntityInterface $entity) {
        $form_factory = $this->container->get('form.factory');
        switch($type) {
            case self::FORM_CREATE:
            case self::FORM_EDIT:
                return $form_factory->createBuilder($this->getFormType(), $entity);
                break;
            case self::FORM_DELETE:
                return $form_factory->createBuilder();
                break;
        }
        throw new \LogicException('Invalid type given ('.$type.'). Should be one of EntityController::FORM_XXX constants.');
    }

    /**
     * Creates a form to create a related entity.
     *
     * @param EntityInterface $entity The entity
     * @param string $string The string to translate
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createCreateForm(EntityInterface $entity, $string='action.entity.create')
    {
        return $this->getFormBuilder(self::FORM_CREATE, $entity)
            ->setAction($this->generateUrl($this->getRouteName('create'), $entity->getUrlParams()))
            ->setMethod('POST')
            ->add('submit', 'submit', array('label' => $this->get('translator')->trans($string)))
            ->getForm()
            ;
    }

    /**
     * Creates a form to edit a related entity.
     *
     * @param EntityInterface $entity The entity
     * @param string $string The string to translate
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createEditForm(EntityInterface $entity, $string='action.entity.update')
    {
        return $this->getFormBuilder(self::FORM_EDIT, $entity)
            ->setAction($this->generateUrl($this->getRouteName('update'), $entity->getUrlParams()))
            ->setMethod('PUT')
            ->add('submit', 'submit', array('label' => $this->get('translator')->trans($string)))
            ->getForm()
            ;
    }

    /**
     * Creates a form to delete a related entity.
     *
     * @param EntityInterface $entity The entity
     * @param string $string The string to translate
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createDeleteForm(EntityInterface $entity, $string='action.entity.delete')
    {
        return $this->getFormBuilder(self::FORM_DELETE, $entity)
            ->setAction($this->generateUrl($this->getRouteName('delete'), $entity->getUrlParams()))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => $this->get('translator')->trans($string)))
            ->getForm()
            ;
    }

} 
