<?php

namespace TestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        return array();
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
}
