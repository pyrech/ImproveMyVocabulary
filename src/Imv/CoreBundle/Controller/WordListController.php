<?php

namespace Imv\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Imv\CoreBundle\Entity\WordList;
use Imv\CoreBundle\Form\WordListType;

/**
 * WordList controller.
 *
 * @Route("/list")
 */
class WordListController extends EntityController
{
    /**
     * @inheritdoc
     */
    protected function getRepositoryName()
    {
        return 'ImvCoreBundle:WordList';
    }

    /**
     * @inheritdoc
     */
    protected function getRouteNamePrefix()
    {
        return 'imv_wordlist';
    }

    /**
     * @inheritdoc
     */
    protected function getFormType()
    {
        return new WordListType();
    }

    /**
     * Lists all Word entities.
     *
     * @Route("/", name="imv_wordlist")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $wordlists = $this->getRepository()->findAll();
        return array('wordlists' => $wordlists);
    }

    /**
     * Finds and displays a WordList entity and its attached words.
     *
     * @Route("/{id}", requirements={"id" = "\d+"}, name="imv_wordlist_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Wordlist $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView()
        );
    }

    /**
     * Creates a new Wordlist entity.
     *
     * @Route("/", name="imv_wordlist_create")
     * @Method("POST")
     * @Template("ImvCoreBundle:Wordlist:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new WordList();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('imv_wordlist_show', $entity->getUrlParams()));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Word entity.
     *
     * @Route("/new", name="imv_wordlist_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new WordList();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing WordList entity.
     *
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="imv_wordlist_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Wordlist $entity)
    {
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing WordList entity.
     *
     * @Route("/{id}", requirements={"id" = "\d+"}, name="imv_wordlist_update")
     * @Method("PUT")
     * @Template("ImvCoreBundle:WordList:edit.html.twig")
     */
    public function updateAction(Request $request, Wordlist $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->getManager()->flush();

            return $this->redirect($this->generateUrl('imv_wordlist_edit', $entity->getUrlParams()));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a WordList entity.
     *
     * @Route("/{id}", requirements={"id" = "\d+"}, name="imv_wordlist_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Wordlist $entity)
    {
        $form = $this->createDeleteForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getManager();
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('imv_wordlist'));
    }
}
