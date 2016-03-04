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
        }

        return array(
          'form' => $form->createView()
        );
    }
}
