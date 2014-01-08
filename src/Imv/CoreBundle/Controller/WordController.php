<?php

namespace Imv\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Imv\CoreBundle\Entity\Word;
use Imv\CoreBundle\Form\WordType;

/**
 * Word controller.
 *
 * @Route("/word")
 */
class WordController extends EntityController
{
    /**
     * @inheritdoc
     */
    protected function getRepositoryName()
    {
        return 'ImvCoreBundle:Word';
    }

    /**
     * @inheritdoc
     */
    protected function getRouteNamePrefix()
    {
        return 'imv_word';
    }

    /**
     * @inheritdoc
     */
    protected function getFormType()
    {
        return new WordType();
    }

    /**
     * Creates a new Word entity.
     *
     * @Route("/", name="imv_word_create")
     * @Method("POST")
     * @Template("ImvCoreBundle:Word:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Word();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('imv_word_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Word entity.
     *
     * @Route("/new", name="imv_word_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Word();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Word entity.
     *
     * @Route("/{id}", requirements={"id": "\d+"}, name="imv_word_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Word $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Word entity.
     *
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="imv_word_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Word $entity)
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
     * Edits an existing Word entity.
     *
     * @Route("/{id}", requirements={"id" = "\d+"}, name="imv_word_update")
     * @Method("PUT")
     * @Template("ImvCoreBundle:Word:edit.html.twig")
     */
    public function updateAction(Request $request, Word $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->getManager()->flush();

            return $this->redirect($this->generateUrl('imv_word_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Word entity.
     *
     * @Route("/{id}", requirements={"id" = "\d+"}, name="imv_word_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Word $entity)
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
