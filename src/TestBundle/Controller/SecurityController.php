<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="student/security/login")
     * @Template()
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        if($error){
            $this->get('session')->getFlashBag()->set('error', '<b>Ooops!</b> Zlé meno alebo heslo.');
        }

        return array(
            'last_username' => $lastUsername,
            'error'         => $error,
        );
    }

    /**
     * @Route("/student/security/logout", name="student/security/logout")
     * @Template()
     */
    public function logoutAction()
    {
        return array(
            // ...
        );
    }

    /**
     * @Route("/student/security/loginCheck", name="_login_check_student")
     * @Template()
     */
    public function loginCheckAction()
    {
    }

    /**
     * @Route("/login-teacher", name="teacher/security/login")
     * @Template()
     */
    public function loginTeacherAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        if($error){
            $this->get('session')->getFlashBag()->set('error', '<b>Ooops!</b> Zlé meno alebo heslo.');
        }

        return array(
            'last_username' => $lastUsername,
            'error'         => $error,
        );
    }

    /**
     * @Route("/teacher/security/logout", name="teacher/security/logout")
     * @Template()
     */
    public function logoutTeacherAction()
    {
        return array(
            // ...
        );
    }

    /**
     * @Route("/teacher/security/loginCheck", name="_login_check_teacher")
     * @Template()
     */
    public function loginTeacherCheckAction()
    {
    }

}
