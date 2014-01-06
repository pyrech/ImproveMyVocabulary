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
    public function showAction($id)
    {
        $wordlist = $this->getRepository()->find($id);
        return array('wordlist' => $wordlist);
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

            return $this->redirect($this->generateUrl('imv_wordlist_show', array('id' => $entity->getId())));
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
}
