<?php

namespace TestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TestBundle\Entity\ReturnedTest;
use TestBundle\Form\ReturnedTestType;
use TestBundle\Entity\User;
use TestBundle\Form\UserAddType;

/**
 * Class UserController
 * @package TestBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Route("/student/", name="student/index")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $subjects = $this->getDoctrine()->getRepository('TestBundle:User')->find($user)->getSubjects();

        return array(
            'subjects' => $subjects
        );
    }

    /**
     * @Route("/register", name="student/register")
     * @Template()
     */
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(new UserAddType(), $user);
        $form->handleRequest($request);

        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        if($form->isValid()){
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', '<b>Výborne!</b> Bol si zaregistrovaný. Teraz sa môžeš prihlásiť');

            return $this->redirectToRoute('student/register');
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/teacher/enable-user/{id}", name="user/enable")
     */
    public function enableUserAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("TestBundle:User")->find($id);
        if(!$user) {
            throw new NotFoundHttpException("Takýto používateľ nebol nájdený.");
        }
        $user->setIsEnabled(true);
        $em->persist($user);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Žiak '.$user->getUsername().' dostal povolenie vstupovať do systému');

        return $this->redirectToRoute("teacher/index");
    }

    /**
     * @Route("/teacher/disable-user/{id}", name="user/disable")
     */
    public function disableUserAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("TestBundle:User")->find($id);
        if(!$user) {
            throw new NotFoundHttpException("Takýto používateľ nebol nájdený.");
        }
        $user->setIsEnabled(false);
        $em->persist($user);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Žiak '.$user->getUsername().' dostal zákaz vstupovať do systému');

        return $this->redirectToRoute("teacher/index");
    }

    /**
     * @Route("/student/show-subject/{id}", name="user/show/subject")
     * @Template()
     */
    public function showSubjectAction($id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $subject = $this->getDoctrine()->getRepository('TestBundle:Subject')->find($id);
        foreach($subject->getTests() as $test){
            $testIds[] = $test->getId();
        }

        $disabledTests = $this->getDoctrine()->getRepository('TestBundle:ReturnedTest')
            ->createQueryBuilder('rt')
            ->where('rt.test IN (:tests)')
            ->andWhere('rt.subject = :subject')
            ->setParameters(array(
                'tests' => $testIds,
                'subject' => $subject->getId()
            ))
            ->getQuery()
            ->getResult()
            ;

        if(!in_array($user, $subject->getUsers()->toArray())) {
            throw new AccessDeniedHttpException("Nemáš prístup do tohto predmetu");
        }

        return array(
            'subject' => $subject,
            'disabledTests' => $disabledTests
        );
    }

    /**
     * @Route("/student/subject/{sid}/test/{tid}/return", name="user/return-test")
     * @Template()
     */
    public function returnTestAction(Request $request, $sid, $tid)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $test = $this->getDoctrine()->getRepository('TestBundle:Test')->find($tid);
        $subject = $this->getDoctrine()->getRepository('TestBundle:Subject')->find($sid);
        $gotTest = $this->getDoctrine()->getRepository('TestBundle:ReturnedTest')->findBy(array(
            'test' => $test,
            'subject' => $subject
        ));
        if($gotTest) {
            throw new AccessDeniedHttpException("Tento test si už odovzdával! Ak si myslíš, že je to chyba kontaktuj jedného z vyučujúcich.");
        }
        $returnedTest = new ReturnedTest();
        $form = $this->createForm(new ReturnedTestType(), $returnedTest);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $returnedTest->setTest($test);
            $returnedTest->setUser($user);
            $returnedTest->setSubject($subject);
            $em->persist($returnedTest);
            $returnedTest->upload();
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Test bol odovzdaný');

            return $this->redirectToRoute('student/index');
        }

        return array(
            'form' => $form->createView()
        );
    }
}
