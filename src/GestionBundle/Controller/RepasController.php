<?php

namespace GestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GestionBundle\Form\RepasType;
use GestionBundle\Entity\Repas;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\ Generator\UrlGeneratorInterface;
class RepasController extends Controller
{
    public  function AjouterAction(Request $request)
    {
        $repas = new Repas();

        $form = $this->createForm(Repastype::class,$repas);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $file=$repas->getPhoto();
            $filename= md5(uniqid())   . '.' . $file->guessExtension();
            $file->move($this->getParameter('Photos_directory'),$filename);
            $repas->setPhoto($filename);
            $em->persist($repas);
            $em->flush();
            return $this->redirectToRoute('Liste_Repas');
        }
        return $this->render('@Gestion/Repas/AjoutR.html.twig',array('form'=> $form->createView()));
    }

    public  function listRepasAction(Request $request)
    {

        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $Repas=$em->getRepository('GestionBundle:Repas')->findAll();
        return $this->render('@Gestion/Repas/AfficherR.html.twig',array('Repas'=> $Repas));
    }

    public function  AfficherRAction(Request $request)
    {
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $Repas=$em->getRepository('GestionBundle:Repas')->findAll();
        return $this->render('@Gestion/Repas/list.html.twig',array('Repas'=> $Repas));
    }

    public function SupprimerRAction(Request $request)
    {
        $id= $request->get('id');
        $em=$this->getDoctrine()->getManager();
        $repas=$em->getRepository('GestionBundle:Repas')->find($id);
        $em->remove($repas);
        $em->flush();
        return $this->redirectToRoute('Liste_Repas');
    }

    public function ModifierRAction(Request $request,$id)
    {

        $em= $this->getDoctrine()->getManager(); // 1  création d'un manager
        $repas = $em->getRepository('GestionBundle:Repas')->find($id); // 2 création du CRUD
        $repas->setNomMenu($repas->getNomMenu()); // 3 préparation des champs au modifier
        $repas->setType($repas->getType());
        $form=$this->createForm(RepasType::class , $repas); // 4 création d'un formulaire = EtudiantType
        $form->handleRequest($request);

        //5 si le formulaire est cliqué

        if($form->isSubmitted() && $form->isValid()){

            $nom=$form['nomMenu']->getData();
            $type=$form['type']->getData();
            //création d'un entityManager

            $em=$this->getDoctrine()->getManager();
            $repas=$em->getRepository('GestionBundle:Repas')->find($id);
            $repas->setNomMenu($nom);
            $repas->setType($type);
            $file=$repas->getPhoto();
            $filename= md5(uniqid())   . '.' . $file->guessExtension();
            $file->move($this->getParameter('Photos_directory'),$filename);
            $repas->setPhoto($filename);
            $em->flush();

            return $this->redirectToRoute('Liste_Repas');

        }

        return $this->render('@Gestion/Repas/AjoutR.html.twig', array('form' => $form->createView()));
    }

    public function ImprimerAction(Request $request)
    {

        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $Repas=$em->getRepository('GestionBundle:Repas')->findAll();
        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView('@Gestion/Repas/ImprimerAB.html.twig', array('Repas'=> $Repas),UrlGeneratorInterface::ABSOLUTE_URL);
        /*$html = $this->renderView('@Gestion/Repas/impression.html.twig', array(
            'title' => 'Hello World !'
        ));*/
        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );

    }
}
