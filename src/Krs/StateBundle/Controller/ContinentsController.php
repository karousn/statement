<?php

namespace Krs\StateBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Krs\StateBundle\Entity\Continents;
use Krs\StateBundle\Form\ContinentsType;

/**
 * Continents controller.
 *
 * @Route("/continents")
 */
class ContinentsController extends Controller
{

    /**
     * Lists all Continents entities.
     *
     * @Route("/", name="continents")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KrsStateBundle:Continents')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Continents entity.
     *
     * @Route("/", name="continents_create")
     * @Method("POST")
     * @Template("KrsStateBundle:Continents:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Continents();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('continents_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Continents entity.
    *
    * @param Continents $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Continents $entity)
    {
        $form = $this->createForm(new ContinentsType(), $entity, array(
            'action' => $this->generateUrl('continents_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Continents entity.
     *
     * @Route("/new", name="continents_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Continents();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Continents entity.
     *
     * @Route("/{id}", name="continents_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KrsStateBundle:Continents')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Continents entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Continents entity.
     *
     * @Route("/{id}/edit", name="continents_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KrsStateBundle:Continents')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Continents entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Continents entity.
    *
    * @param Continents $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Continents $entity)
    {
        $form = $this->createForm(new ContinentsType(), $entity, array(
            'action' => $this->generateUrl('continents_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Continents entity.
     *
     * @Route("/{id}", name="continents_update")
     * @Method("PUT")
     * @Template("KrsStateBundle:Continents:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KrsStateBundle:Continents')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Continents entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('continents_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Continents entity.
     *
     * @Route("/{id}", name="continents_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KrsStateBundle:Continents')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Continents entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('continents'));
    }

    /**
     * Creates a form to delete a Continents entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('continents_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
