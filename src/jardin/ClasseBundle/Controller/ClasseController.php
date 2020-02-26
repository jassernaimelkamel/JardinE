<?php

namespace jardin\ClasseBundle\Controller;

use ClasseBundle\Form\ClasseType;
use jardin\ClasseBundle\Entity\Classe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Classe controller.
 *
 */
class ClasseController extends Controller
{
    /**
     * Lists all classe entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $classes = $em->getRepository('classeBundle:Classe')->findAll();

        return $this->render('classe/index.html.twig', array(
            'classes' => $classes,
        ));
    }

    /**
     * Creates a new classe entity.
     *
     */
    public function newAction(Request $request)
    {
        $classe = new Classe();
        $form = $this->createForm('jardin\ClasseBundle\Form\ClasseType', $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classe);
            $em->flush();

            return $this->redirectToRoute('classe_show', array('id' => $classe->getId()));
        }

        return $this->render('classe/new.html.twig', array(
            'classe' => $classe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a classe entity.
     *
     */
    public function showAction(Classe $classe)
    {
        $deleteForm = $this->createDeleteForm($classe);

        return $this->render('classe/show.html.twig', array(
            'classe' => $classe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing classe entity.
     *
     */
    public function editAction(Request $request, Classe $classe)
    {
        $deleteForm = $this->createDeleteForm($classe);
        $editForm = $this->createForm('jardin\ClasseBundle\Form\ClasseType', $classe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('classe_edit', array('id' => $classe->getId()));
        }

        return $this->render('classe/edit.html.twig', array(
            'classe' => $classe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a classe entity.
     *
     */
    public function deleteAction(Request $request, Classe $classe)
    {
        $form = $this->createDeleteForm($classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($classe);
            $em->flush();
        }

        return $this->redirectToRoute('classe_index');
    }

    /**
     * Creates a form to delete a classe entity.
     *
     * @param Classe $classe The classe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Classe $classe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('classe_delete', array('id' => $classe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all classe entities.
     *
     */
    public function index2Action()
    {
        $em = $this->getDoctrine()->getManager();

        $classes = $em->getRepository('classeBundle:Classe')->findAll();

        return $this->render('ClasseAdmin/index.html.twig', array(
            'classes' => $classes,
        ));
    }


    public function ajouterClasseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $enfants_totale = $em->getRepository("EnfantsBundle:Enfants")->findAll();

        $classe = $em->getRepository("classeBundle:Classe")->findAll();
        $nbr_classe = count($classe);

        $parents = $em->getRepository("MainBundle:User")->rechercherUserParent();
        $nbre_parents = count($parents);
        $nbr_totale = count($enfants_totale);
        $classe = new  Classe;
        $form = $this->createForm(\jardin\ClasseBundle\Form\ClasseType::class,$classe);
        $form->HandleRequest($request);


        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classe);
            $em->flush();

#redirection vers la page d'affichage

            return $this->redirectToRoute('classe_afficherClasse');

#

        }

        return $this->render("ClasseAdmin/new.html.twig",array('form'=>$form->createView(),'nbr_tt'=>$nbr_totale
        ,'nbr_parent'=>$nbre_parents,'nbr_classe'=>$nbr_classe));
    }

    public function afficherClasseAction ()
    {
        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository("classeBundle:Classe")->findAll();
        return $this->render("ClasseAdmin/index.html.twig",array('classe'=>$classe));
    }
    public function supprimerClasseAction ($id)
    {
        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository("classeBundle:Classe")->find($id);
        $em->remove($classe);
        $em->flush();
        return $this->redirectToRoute('classe_afficherClasse');
    }

    public function modifierClasseAction (Request $request, $id )
    {
        $classe = new Classe();
        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository('classeBundle:Classe')->find($id);

        $form = $this->createForm(\jardin\ClasseBundle\Form\ClasseType::class,$classe);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em->persist($classe);
            $em->flush();
            return $this->redirectToRoute('classe_afficherClasse');
        }
        return $this->render('ClasseAdmin/edit.html.twig',array('form'=>$form->createView()));
    }
    public function voirClasseAction ($id)
    {
        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository("classeBundle:Classe")->find($id);
        return $this->render("ClasseAdmin/show.html.twig",array('classe'=>$classe));
    }
}
