<?php

namespace TestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReturnedTestController extends Controller
{
    /**
     * @Route("/teacher/test/{parent_id}/returned-test/{id}/delete", name="returned-test/delete")
     */
    public function deleteAction($parent_id, $id)
    {
        $returnedTest = $this->getDoctrine()->getRepository('TestBundle:ReturnedTest')->find($id);

        if(!$returnedTest) {
            $this->get('session')->getFlashBag()->add('error', 'Tento záznam nebol najdený');

            return $this->redirectToRoute('test/detail', array('id' => $parent_id));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($returnedTest);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Odovzdaný test bol vymazaný.');

        return $this->redirectToRoute('test/detail', array('id' => $parent_id));
    }
}
