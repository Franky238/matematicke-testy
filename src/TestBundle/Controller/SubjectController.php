<?php

namespace TestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\Subject;
use TestBundle\Form\SubjectAddType;
use TestBundle\Form\UsersToSubjectType;

/**
 * @Route("/teacher")
 *
 * Class SubjectController
 * @package TestBundle\Controller
 */
class SubjectController extends Controller
{
    /**
     * @Route("/subjects", name="subject/index")
     * @Template()
     */
    public function indexAction()
    {
        $subjects = $this->getDoctrine()->getRepository('TestBundle:Subject')->findAll();

        return array(
            'subjects' => $subjects
        );
    }

    /**
     * @Route("/subject/{id}/detail", name="subject/detail")
     * @Template()
     */
    public function detailAction($id)
    {
        $subject = $this->getDoctrine()->getRepository('TestBundle:Subject')->find($id);

        return array(
            'subject' => $subject
        );
    }

    /**
     * @Route("/create-subject", name="subject/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $teacher = $this->get('security.token_storage')->getToken()->getUser();
        $subject = new Subject();
        $form = $this->createForm(new SubjectAddType(), $subject);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Predmet <a href="'.$this->generateUrl("subject/detail", array("id" => $subject->getId())).'">'.$subject->getName().'</a> bol vytvorený.');


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
            $this->get('session')->getFlashBag()->add('success', 'Predmet <a href="'.$this->generateUrl("subject/detail", array("id" => $subject->getId())).'">'.$subject->getName().'</a> bol upravený.');

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

    /**
     * @Route("/subject/{id}/add-students", name="subject/add-students")
     * @Template()
     */
    public function addUsersToSubjectAction(Request $request, $id)
    {
        $subject = $this->getDoctrine()->getRepository('TestBundle:Subject')->find($id);
        $form = $this->createForm(new UsersToSubjectType(), $subject);
        $form->handleRequest($request);

        if($form->isValid()){
            $users = $subject->getUsers();
            $em = $this->getDoctrine()->getManager();
            foreach($users as $user) {
                $user->addSubject($subject);
                $em->persist($user);
            }
            $em->persist($subject);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Študenti boli pridaný do predmetu <a href="'
                .$this->generateUrl("subject/detail", array("id" => $subject->getId())).'">'.$subject->getName().'</a>');

            return $this->redirectToRoute("teacher/index");
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/teacher/subject/{id}/delete", name="subject/delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $subject = $em->getRepository('TestBundle:Subject')->find($id);

        if(!$subject) {
            $this->get('session')->getFlashBag()->add('error', 'Tento záznam nebol najdený');

            return $this->redirectToRoute('subject/index');
        }

        $em->remove($subject);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Predmet bol vymazaný');

        return $this->redirectToRoute('subject/index');
    }
}
