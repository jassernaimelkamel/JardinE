<?php

namespace GestionBundle\Controller;

use GestionBundle\Entity\Trajets;
use GestionBundle\Form\TrajetsType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;

class TrajetsController extends Controller
{
    public function IndexAction(Request $request)
    {
        $repas = new Trajets();
        $form = $this->createForm(TrajetsType::class,$repas);
        $form->handleRequest($request);
        //  return $this->render('@Gestion/Trajets/localisation.html.twig',array('form'=>$form->createView()));
        return $this->render('@Gestion/Trajets/geolocalisation.html.twig');
    }
}

