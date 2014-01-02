<?php

namespace Imv\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * WordList controller.
 *
 * @Route("/list")
 */
class WordListController extends Controller
{
    private function getRepository() {
        // On récupère le repository
        return $this->getDoctrine()
                    ->getManager()
                    ->getRepository('ImvCoreBundle:WordList');
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
        $em = $this->getDoctrine()->getManager();
        $repos = $em->getRepository('ImvCoreBundle:WordList');

        $wordlists = $this->getRepository()->findAll();
        return array('wordlists' => $wordlists);
    }

    /**
     * Finds and displays a WordList entity and its attached words.
     *
     * @Route("/{id}", name="imv_wordlist_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $repository = $this->getRepository();
        $wordlist = $repository->find($id);
        $words = $wordlist->getWords();
        return array('wordlist' => $wordlist);
    }
}
