<?php

namespace NutricionBundle\Controller;

use NutricionBundle\Entity\Periodocierre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Periodocierre controller.
 *
 */
class PeriodocierreController extends Controller
{
    /**
     * Lists all periodocierre entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $periodocierres = $em->getRepository('NutricionBundle:Periodocierre')->findAll();

        return $this->render('periodocierre/index.html.twig', array(
            'periodocierres' => $periodocierres,
        ));
    }

    /**
     * Creates a new periodocierre entity.
     *
     */
    public function newAction(Request $request)
    {
        $periodocierre = new Periodocierre();
        $form = $this->createForm('NutricionBundle\Form\PeriodocierreType', $periodocierre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($periodocierre);
            $em->flush();

            return $this->redirectToRoute('periodocierre_show', array('id' => $periodocierre->getId()));
        }

        return $this->render('periodocierre/new.html.twig', array(
            'periodocierre' => $periodocierre,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a periodocierre entity.
     *
     */
    public function showAction(Periodocierre $periodocierre)
    {
        $deleteForm = $this->createDeleteForm($periodocierre);

        return $this->render('periodocierre/show.html.twig', array(
            'periodocierre' => $periodocierre,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing periodocierre entity.
     *
     */
    public function editAction(Request $request, Periodocierre $periodocierre)
    {
        $deleteForm = $this->createDeleteForm($periodocierre);
        $editForm = $this->createForm('NutricionBundle\Form\PeriodocierreType', $periodocierre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('periodocierre_edit', array('id' => $periodocierre->getId()));
        }

        return $this->render('periodocierre/edit.html.twig', array(
            'periodocierre' => $periodocierre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a periodocierre entity.
     *
     */
    public function deleteAction(Request $request, Periodocierre $periodocierre)
    {
        $form = $this->createDeleteForm($periodocierre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($periodocierre);
            $em->flush();
        }

        return $this->redirectToRoute('periodocierre_index');
    }

    /**
     * Creates a form to delete a periodocierre entity.
     *
     * @param Periodocierre $periodocierre The periodocierre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Periodocierre $periodocierre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('periodocierre_delete', array('id' => $periodocierre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
