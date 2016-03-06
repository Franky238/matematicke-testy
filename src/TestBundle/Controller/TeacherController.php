<?php

namespace TestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\Teacher;
use TestBundle\Form\TeacherAddType;

/**
 * @Route("/teacher")
 * Class TeacherController
 * @package TestBundle\Controller
 */
class TeacherController extends Controller
{
    /**
     * @Route("/", name="teacher/index")
     * @Template()
     */
    public function indexAction()
    {
        $maxResult = 5;
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TestBundle:User')->findBy(array(), array('id' => 'DESC'), $maxResult);
        $tests = $em->getRepository('TestBundle:Test')->findBy(array(), array('id' => 'DESC'), $maxResult);
        $subjects = $em->getRepository('TestBundle:Subject')->findBy(array(), array('id' => 'DESC'), $maxResult);
        $noLimitedSubjects = $em->getRepository('TestBundle:Subject')->findAll();
        $noLimitedUsers = $em->getRepository('TestBundle:User')->findAll();

        return array(
            'users' => $users,
            'tests' => $tests,
            'subjects' => $subjects,
            'noLimitedSubjects' => $noLimitedSubjects,
            'noLimitedUsers' => $noLimitedUsers,
        );
    }

    /**
     * @Route("/register", name="teacher/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $teacher = new Teacher();
        $form = $this->createForm(new TeacherAddType(), $teacher);
        $form->handleRequest($request);
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($teacher);

        if($form->isValid()) {
            $password = $encoder->encodePassword($teacher->getPassword(), $teacher->getSalt());
            $teacher->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($teacher);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', '<b>Výborne!</b> Učiteľ bol zaregistrovaný. Teraz sa môže prihlásiť');
        }

        return array(
          'form' => $form->createView()
        );
    }

    /**
     * @Route("/directory", name="teacher/student-list")
     * @Template()
     */
    public function studentListAction()
    {
        $users = $this->getDoctrine()->getRepository('TestBundle:User')->findAll();

        return array(
            'users' => $users
        );
    }

    /**
     * @Route("/teacher-list", name="teacher/teacher-list")
     * @Template()
     */
    public function teacherListAction()
    {
        $teachers = $this->getDoctrine()->getRepository('TestBundle:Teacher')->findAll();

        return array(
            'teachers' => $teachers
        );
    }

}
