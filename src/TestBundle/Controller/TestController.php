<?php

namespace TestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\Test;
use TestBundle\Form\TestUploadType;

/**
 * @Route("/teacher")
 *
 * Class TestController
 * @package TestBundle\Controller
 */
class TestController extends Controller
{
    /**
     * @Route("/tests", name="test/index")
     * @Template()
     */
    public function indexAction()
    {
        $tests = $this->getDoctrine()->getRepository('TestBundle:Test')->findAll();

        return array(
            'tests' => $tests
        );
    }

    /**
     * @Route("/create-test", name="test/create")
     * @Template()
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $test = new Test();
        $form = $this->createForm(new TestUploadType(), $test);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $test->upload();
            $em->persist($test);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Test bol vytvorený');

            return $this->redirectToRoute('teacher/index');
        }

        return array(
          'form' => $form->createView()
        );
    }

    /**
     * @Route("/test/{id}", name="test/detail")
     * @Template()
     */
    public function detailAction($id)
    {
        $test = $this->getDoctrine()->getRepository('TestBundle:Test')->find($id);
        $returnedTests = $this->getDoctrine()->getRepository('TestBundle:ReturnedTest')->findBy(array(
            'test' => $test
        ));

        return array(
            'test' => $test,
            'returnedTests' => $returnedTests
        );
    }
}
