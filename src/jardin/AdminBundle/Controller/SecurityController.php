<?php

namespace Medicale\MemberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
   /* public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

   */

    /**
     * @Route("/Admin")
     */
    public function redirectAction( Request $request){

        if($this->getUser()->hasRole('ROLE_ADMIN'))
            return $this->render('@Admin/Default/admin.html.twig');
        elseif($this->getUser()->hasRole('ROLE_USER'))
            return $this->render('@Admin/Default/user_home.html.twig');
        throw new \Exception(AccessDeniedException::class);
    }

}
