<?php

namespace ActiviteBundle\Controller;

use ActiviteBundle\Entity\Animateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Animateur controller.
 *
 * @Route("animateur")
 */
class AnimateurController extends Controller
{
    /**
     * Lists all animateur entities.
     *
     * @Route("/", name="animateur_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $animateurs = $em->getRepository('ActiviteBundle:Animateur')->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $animateurs,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',2)
        );

        return $this->render('animateur/index.html.twig', array(
            'animateurs' => $result,
        ));
    }

    /**
     * Creates a new animateur entity.
     *
     * @Route("/new", name="animateur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $animateur = new Animateur();
        $form = $this->createForm('ActiviteBundle\Form\AnimateurType', $animateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $file */
            $file = $animateur->getPhoto();
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $filename);
            $animateur->setPhoto($filename);

            $em = $this->getDoctrine()->getManager();
            $em->persist($animateur);
            $em->flush();

            return $this->redirectToRoute('animateur_show', array('id' => $animateur->getId()));
        }

        return $this->render('animateur/new.html.twig', array(
            'animateur' => $animateur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a animateur entity.
     *
     * @Route("/{id}", name="animateur_show")
     * @Method("GET")
     */
    public function showAction(Animateur $animateur)
    {
        $deleteForm = $this->createDeleteForm($animateur);

        return $this->render('animateur/show.html.twig', array(
            'animateur' => $animateur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing animateur entity.
     *
     * @Route("/{id}/edit", name="animateur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Animateur $animateur)
    {
        $deleteForm = $this->createDeleteForm($animateur);
        $editForm = $this->createForm('ActiviteBundle\Form\AnimateurType', $animateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('animateur_edit', array('id' => $animateur->getId()));
        }

        return $this->render('animateur/edit.html.twig', array(
            'animateur' => $animateur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a animateur entity.
     *
     * @Route("/{id}", name="animateur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Animateur $animateur)
    {
        $form = $this->createDeleteForm($animateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($animateur);
            $em->flush();
        }

        return $this->redirectToRoute('animateur_index');
    }

    /**
     * Creates a form to delete a animateur entity.
     *
     * @param Animateur $animateur The animateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Animateur $animateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('animateur_delete', array('id' => $animateur->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
