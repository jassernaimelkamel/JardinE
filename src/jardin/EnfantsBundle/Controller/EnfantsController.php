<?php

namespace jardin\EnfantsBundle\Controller;

use jardin\EnfantsBundle\Entity\Enfants;
use jardin\EnfantsBundle\Form\EnfantsType;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Enfant controller.
 *
 */
class EnfantsController extends Controller
{
    /**
     * Lists all enfant entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $enfants = $em->getRepository('EnfantsBundle:Enfants')->findAll();

        return $this->render('enfants/index.html.twig', array(
            'enfants' => $enfants,
        ));
    }

    /**
     * Creates a new enfant entity.
     *
     */
    public function newAction(Request $request)
    {

        $enfant = new Enfants();
        $form = $this->createForm('jardin\EnfantsBundle\Form\EnfantsType', $enfant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enfant);
            $em->flush();

            return $this->redirectToRoute('enfants_show', array('id' => $enfant->getId()));
        }

        return $this->render('enfants/new.html.twig', array(
            'enfant' => $enfant,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a enfant entity.
     *
     */
    public function showAction(Enfants $enfant)
    {
        $deleteForm = $this->createDeleteForm($enfant);

        return $this->render('enfants/show.html.twig', array(
            'enfant' => $enfant,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing enfant entity.
     *
     */
    public function editAction(Request $request, Enfants $enfant)
    {
        $deleteForm = $this->createDeleteForm($enfant);
        $editForm = $this->createForm('jardin\EnfantsBundle\Form\EnfantsType', $enfant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('enfants_edit', array('id' => $enfant->getId()));
        }

        return $this->render('enfants/edit.html.twig', array(
            'enfant' => $enfant,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a enfant entity.
     *
     */
    public function deleteAction(Request $request, Enfants $enfant)
    {
        $form = $this->createDeleteForm($enfant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enfant);
            $em->flush();
        }

        return $this->redirectToRoute('enfants_index');
    }

    /**
     * Creates a form to delete a enfant entity.
     *
     * @param Enfants $enfant The enfant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Enfants $enfant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('enfants_delete', array('id' => $enfant->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }






    public function ajouterEnfantsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $enfants_totale = $em->getRepository("EnfantsBundle:Enfants")->findAll();

        $classe = $em->getRepository("classeBundle:Classe")->findAll();
        $nbr_classe = count($classe);

        $parents = $em->getRepository("MainBundle:User")->rechercherUserParent();
        $nbre_parents = count($parents);
        $nbr_totale = count($enfants_totale);

        $enfants = new Enfants();
        $form = $this->createForm(enfantsType::class,$enfants);
        $form->HandleRequest($request);

        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enfants);
            $em->flush();

#redirection vers la page d'affichage

            return $this->redirectToRoute('enfants_index2');

#

        }

        return $this->render(":EnfantsAdmin:new.html.twig",array('form'=>$form->createView(),'nbr_tt'=>$nbr_totale
        ,'nbr_parent'=>$nbre_parents,'nbr_classe'=>$nbr_classe));
    }

    public function index2Action (Request $request)
    {
        $ob = new Highchart();
        $ob->chart->renderTo('linechart');
        $ob->title->text('Enfants');
        $ob->plotOptions->pie(array('allowPointSelect' => true, 'cursor' => 'pointer', 'dataLabels' => array('enabled' => false),
            'showInLegend' => true));
        // $em = $this->container->get('doctrine')->getEntityManager();
        $em=$this->getDoctrine()->getManager();

        $enfants = $em->getRepository('EnfantsBundle:Enfants')->rechercherEnfantsParSexe();

        $enfants_array = json_decode(json_encode($enfants),true);


//        var_dump($enfants_array);
        $nbr = count($enfants);
        //var_dump($nbr);

//        $o = '55';
//        $oo = intval($o*100);

//        var_dump($oo);
        $data = array();

        $j = 0;
        while($j < $nbr) {

//            var_dump($j);

            $stat = array();
            // var_dump($fiches[$j]["etat"]);$fiches[$j]["nombre"];

//            $nbr_people = intval($enfants[$j]["nombre"]);

            array_push($stat, "Le sexe : " . $enfants_array[$j]["sexe"], intval($enfants_array[$j]["nombre"]));
            //var_dump($stat);
            array_push($data, $stat);

            //var_dump($stat);


            $j++;

        }




//        var_dump($data);
        $ob->series(array(array('type' => 'pie', 'name' => 'Leur nombre est de : ', 'data' => $data)));

        /// fin stat
        $em = $this->getDoctrine()->getManager();
        $boy = $em->getRepository("EnfantsBundle:Enfants")->rechercherEnfantsBoy();
        $girl = $em->getRepository("EnfantsBundle:Enfants")->rechercherEnfantsGirl();
        $enfants_totale = $em->getRepository("EnfantsBundle:Enfants")->findAll();

        $classe = $em->getRepository("classeBundle:Classe")->findAll();
        $nbr_classe = count($classe);

        $parents = $em->getRepository("MainBundle:User")->rechercherUserParent();
        $nbre_parents = count($parents);


        $nbr_boy = count($boy);
        $nbr_girl= count($girl);
        $nbr_totale = count($enfants_totale);

        if(isset($_POST['rechercherByNom']) && ($request->isMethod('POST'))){
            $nom = $request->get('nom');
            $enfant = $em->getRepository("EnfantsBundle:Enfants")->rechercherEnfantsParNom2($nom);
//            var_dump($enfant);
            return $this->render(":EnfantsAdmin:index.html.twig",array('enfants'=>$enfant,'nbr_boy'=>$nbr_boy,'nbr_girl'=>$nbr_girl,'boy'=>$boy,'girl'=>$girl,'nbr_tt'=>$nbr_totale
            ,'nbr_parent'=>$nbre_parents,'nbr_classe'=>$nbr_classe,'chart' => $ob));
        }
        $enfants = $em->getRepository("EnfantsBundle:Enfants")->findAll();
        return $this->render(":EnfantsAdmin:index.html.twig",array('enfants'=>$enfants,'nbr_boy'=>$nbr_boy,'nbr_girl'=>$nbr_girl,'boy'=>$boy,'girl'=>$girl,'nbr_tt'=>$nbr_totale
        ,'nbr_parent'=>$nbre_parents,'nbr_classe'=>$nbr_classe,'chart' => $ob));
    }

    public function supprimerEnfantsAction ($id)
    {
        $em = $this->getDoctrine()->getManager();
        $enfants = $em->getRepository("EnfantsBundle:Enfants")->find($id);
        $em->remove($enfants);
        $em->flush();
        return $this->redirectToRoute('enfants_index2');
    }

    public function modifierEnfantsAction (Request $request, $id )
    {

        $enfants = new Enfants();
        $em = $this->getDoctrine()->getManager();
        $enfants = $em->getRepository('EnfantsBundle:Enfants')->find($id);

        $form = $this->createForm(EnfantsType::class,$enfants);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em->persist($enfants);
            $em->flush();
            return $this->redirectToRoute('enfants_index2');
        }
        return $this->render('EnfantsAdmin/edit.html.twig',array('form'=>$form->createView()));
    }
    public function voirEnfantsAction ($id)
    {
        $em = $this->getDoctrine()->getManager();
        $enfants = $em->getRepository("EnfantsBundle:Enfants")->find($id);
        return $this->render("EnfantsAdmin/show.html.twig",array('enfant'=>$enfants));
    }

    public function rechercherByNomAction ()
    {
        $enfants = new Enfants();
        $em = $this->getDoctrine()->getManager();
        $enfants = $em->getRepository(enfants::class)->findBy(array('nom'=>$enfants->getNom()));

        return $this->render("@Enfants/Default/rechercher.html.twig",array('enfants'=>$enfants));
    }

    public function obAction()
    {
        $ob = new Highchart();
        $ob->chart->renderTo('linechart');
        $ob->title->text('Enfants');
        $ob->plotOptions->pie(array('allowPointSelect' => true, 'cursor' => 'pointer', 'dataLabels' => array('enabled' => false),
            'showInLegend' => true));
        // $em = $this->container->get('doctrine')->getEntityManager();
        $em=$this->getDoctrine()->getManager();

        $enfants = $em->getRepository('EnfantsBundle:Enfants')->rechercherEnfantsParSexe();

        $enfants_array = json_decode(json_encode($enfants),true);


        var_dump($enfants_array);
        $nbr = count($enfants);
        //var_dump($nbr);

//        $o = '55';
//        $oo = intval($o*100);

//        var_dump($oo);
        $data = array();

        $j = 0;
        while($j < $nbr) {

            var_dump($j);

            $stat = array();
            // var_dump($fiches[$j]["etat"]);$fiches[$j]["nombre"];

//            $nbr_people = intval($enfants[$j]["nombre"]);

            array_push($stat, "Le sexe : " . $enfants_array[$j]["sexe"], intval($enfants_array[$j]["nombre"]));
            //var_dump($stat);
            array_push($data, $stat);

            //var_dump($stat);


            $j++;

        }




        var_dump($data);
        $ob->series(array(array('type' => 'pie', 'name' => 'Leur nombre est de : ', 'data' => $data)));
        return $this->render('@Enfants/Default/statistic.html.twig', array('chart' => $ob));
    }

    public function ob2Action()
    {
        // Chart
        $series = array(
            array("name" => "Data Serie Name",    "data" => array(1,2,4,5,6,3,8))
        );

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $ob->title->text('Chart Title');
        $ob->xAxis->title(array('text'  => "Horizontal axis title"));
        $ob->yAxis->title(array('text'  => "Vertical axis title"));
        $ob->series($series);

        return $this->render('@Enfants/Default/statistic2.html.twig', array(
            'chart' => $ob
        ));
    }


}
