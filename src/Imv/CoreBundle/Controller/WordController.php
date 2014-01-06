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
    * Creates a form to create a Word entity.
    *
    * @param Word $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Word $entity)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new WordType(), $entity, array(
            'action' => $this->generateUrl('imv_word_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => $translator->trans('action.entity.create')));

        return $form;
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
    public function showAction($id)
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Word entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Word entity.
     *
     * @Route("/{id}/edit", name="imv_word_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Word entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Word entity.
    *
    * @param Word $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Word $entity)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new WordType(), $entity, array(
            'action' => $this->generateUrl('imv_word_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => $translator->trans('action.entity.update')));

        return $form;
    }
    /**
     * Edits an existing Word entity.
     *
     * @Route("/{id}", name="imv_word_update")
     * @Method("PUT")
     * @Template("ImvCoreBundle:Word:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Word entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->getManager()->flush();

            return $this->redirect($this->generateUrl('imv_word_edit', array('id' => $id)));
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
     * @Route("/{id}", name="imv_word_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity = $this->getRepository()->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Word entity.');
            }

            $em = $this->getManager();
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('imv_wordlist'));
    }

    /**
     * Creates a form to delete a Word entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $translator = $this->get('translator');
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('imv_word_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => $translator->trans('action.entity.delete')))
            ->getForm()
        ;
    }
}
