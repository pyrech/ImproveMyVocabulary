<?php

namespace Imv\CoreBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Imv\CoreBundle\Entity\EntityInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


abstract class EntityController extends Controller
{
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
     * Creates a form to create a related entity.
     *
     * @param EntityInterface $entity The entity
     * @param string $string The string to translate
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createCreateForm(EntityInterface $entity, $string='action.entity.create')
    {
        return $this->container->get('form.factory')->createBuilder($this->getFormType(), $entity)
            ->setAction($this->generateUrl($this->getRouteName('show'), $entity->getUrlParams()))
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
        return $this->container->get('form.factory')->createBuilder($this->getFormType(), $entity)
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
        return $this->container->get('form.factory')->createBuilder()
            ->setAction($this->generateUrl($this->getRouteName('delete'), $entity->getUrlParams()))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => $this->get('translator')->trans($string)))
            ->getForm()
            ;
    }

} 
