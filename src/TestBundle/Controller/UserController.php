<?php

namespace TestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\User;
use TestBundle\Form\UserAddType;

/**
 * Class UserController
 * @package TestBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Route("/student/")
     *
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
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
            $this->get('session')->getFlashBag()->add('success', 'Boli ste zaregistrovaný');

            return $this->redirectToRoute('student/register');
        }

        return array(
            'form' => $form->createView()
        );
    }
}
