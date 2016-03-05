<?php

namespace TestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\Subject;
use TestBundle\Form\SubjectAddType;

/**
 * @Route("/teacher")
 *
 * Class SubjectController
 * @package TestBundle\Controller
 */
class SubjectController extends Controller
{
    /**
     * @Route("/create-subject", name="subject/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $subject = new Subject();
        $form = $this->createForm(new SubjectAddType(), $subject);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Predmet bol vytvorený');

            return $this->redirectToRoute("teacher/index");
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/edit-subject/{id}", name="subject/edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $subject = $this->getDoctrine()->getRepository('TestBundle:Subject')->find($id);
        $form = $this->createForm(new SubjectAddType(), $subject);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Predmet bol upravený');

            return $this->redirectToRoute("teacher/index");
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/subject/add-student", name="subject/add-student")
     */
    public function addUserToSubjectAction(Request $request)
    {
        $user_id = $request->request->get('user');
        $subject_id = $request->request->get('subject');
        $user = $this->getDoctrine()->getRepository('TestBundle:User')->find($user_id);
        $subject = $this->getDoctrine()->getRepository('TestBundle:Subject')->find($subject_id);
        $user->addSubject($subject);
        $subject->addUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->persist($subject);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Študent '.$user->getUsername().' bol pridaný do predmetu '.$subject->getName());

        return $this->redirectToRoute("teacher/index");
    }
}
