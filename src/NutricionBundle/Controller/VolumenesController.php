<?php

namespace NutricionBundle\Controller;

use NutricionBundle\Entity\Volumenes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use NutricionBundle\Entity\Historial;

/**
 * Volumene controller.
 *
 */
class VolumenesController extends Controller
{
    /**
     * Lists all volumene entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $volumenes = $em->getRepository('NutricionBundle:Volumenes')->findAll();

        return $this->render('volumenes/index.html.twig', array(
            'volumenes' => $volumenes,
        ));
    }

    /**
     * Creates a new volumene entity.
     *
     */
    public function newAction($id,Request $request)
    {
        



        $em = $this->getDoctrine()->getManager();

  $listado = $em->getRepository('NutricionBundle:Volumenes')->findAll();

        $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Planilla p
        WHERE p.id = '$id'
        "
        );

        $datos = $em->getRepository('NutricionBundle:Planilla')->find($id);

        $volumene = new Volumenes();
        $form = $this->createForm('NutricionBundle\Form\VolumenesType', $volumene);
        $form->handleRequest($request);
$ip=$this->getDoctrine()->getEntityManager();  
        if ($form->isSubmitted() && $form->isValid()) {
            
    

        $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Periodocierre p
      ORDER BY p.id DESC "
        )->setMaxResults(1);
        $datos = $queryc->getResult();
        

        foreach ($datos as $valor) {
              $idfechadecierre = $valor->getId();

        }


  
            $em = $this->getDoctrine()->getManager();

//              $fecha = new \DateTime($form->getData()->getFecha());
                /*$fecha =  $form->getData()->getFecha();*/
                

        $volumene->setPlanilla($ip->getReference('NutricionBundle:Planilla',$form->getData()->getIdafiliado())); 
  //            $volumene->setFecha($fecha); 
        $volumene->setPeriodocierre($ip->getReference('NutricionBundle:Periodocierre',$idfechadecierre)); 
            $em->persist($volumene);
            $em->flush();

              $this->get('session')->getFlashBag()->add('add','FACTURA ALMACENADA CON EXITO');               
                     

            /*return $this->redirectToRoute('volumenes_show', array('id' => $volumene->getId()));*/
            //return $this->redirectToRoute('table');
return $this->redirectToRoute('vp', array('id' => $id));


        }

        return $this->render('volumenes/new.html.twig', array(
            'idafiliado' => $id,
            'datos' => $datos,
            'volumene' => $volumene,
            'form' => $form->createView(),
            'listado' => $listado
        ));
    }

    /**
     * Finds and displays a volumene entity.
     *
     */
     public function histAction($id,Request $request)
    {
     


        $em = $this->getDoctrine()->getManager();
        $listado = $em->getRepository('NutricionBundle:Historial')->findAll();





        return $this->render('volumenes/hist.html.twig', array('general' => $listado, 'idafiliado' => $id));
    

  }
    public function showAction(Volumenes $volumene)
    {
        $deleteForm = $this->createDeleteForm($volumene);

        return $this->render('volumenes/show.html.twig', array(
            'volumene' => $volumene,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing volumene entity.
     *
     */
    public function editAction(Request $request, Volumenes $volumene)
    {
        $deleteForm = $this->createDeleteForm($volumene);
        $editForm = $this->createForm('NutricionBundle\Form\VolumenesType', $volumene);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
 $this->get('session')->getFlashBag()->add('edit','FACTURA MODIFICADA CON EXITO');    
            return $this->redirectToRoute('vp', array('id' => $volumene->getIdafiliado()));
        }

        return $this->render('volumenes/edit.html.twig', array(
            'volumene' => $volumene,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a volumene entity.
     *
     */
    public function deleteAction(Request $request, Volumenes $volumene)
    {
        $form = $this->createDeleteForm($volumene);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($volumene);
            $em->flush();
        }

        return $this->redirectToRoute('volumenes_index');
    }

    /**
     * Creates a form to delete a volumene entity.
     *
     * @param Volumenes $volumene The volumene entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Volumenes $volumene)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('volumenes_delete', array('id' => $volumene->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

 public function eliminarAction(Request $request, $idvolumene,$idafiliado)
    {
              $em = $this->getDoctrine()->getManager();

      $volumenes = $em->getRepository('NutricionBundle:Volumenes')->find($idvolumene);
        
        $em->remove($volumenes);
        $em->flush();
$this->get('session')->getFlashBag()->add('fall','FACTURA ELIMINADA CON EXITO');    
     

        return $this->redirectToRoute('vp', array('id' => $idafiliado));
    }


}
