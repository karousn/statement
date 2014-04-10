<?php

namespace Krs\StateBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Krs\StateBundle\Entity\Exchange;
use Krs\StateBundle\Form\ExchangeType;

/**
 * Exchange controller.
 *
 * @Route("/exchange")
 */
class ExchangeController extends Controller
{

    /**
     * Lists all Exchange entities.
     *
     * @Route("/", name="exchange")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KrsStateBundle:Exchange')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Exchange entity.
     *
     * @Route("/", name="exchange_create")
     * @Method("POST")
     * @Template("KrsStateBundle:Exchange:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Exchange();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('exchange_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Exchange entity.
    *
    * @param Exchange $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Exchange $entity)
    {
        $form = $this->createForm(new ExchangeType(), $entity, array(
            'action' => $this->generateUrl('exchange_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Exchange entity.
     *
     * @Route("/new", name="exchange_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Exchange();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Exchange entity.
     *
     * @Route("/{id}", name="exchange_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KrsStateBundle:Exchange')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Exchange entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Exchange entity.
     *
     * @Route("/{id}/edit", name="exchange_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KrsStateBundle:Exchange')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Exchange entity.');
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
    * Creates a form to edit a Exchange entity.
    *
    * @param Exchange $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Exchange $entity)
    {
        $form = $this->createForm(new ExchangeType(), $entity, array(
            'action' => $this->generateUrl('exchange_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Exchange entity.
     *
     * @Route("/{id}", name="exchange_update")
     * @Method("PUT")
     * @Template("KrsStateBundle:Exchange:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KrsStateBundle:Exchange')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Exchange entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('exchange_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Exchange entity.
     *
     * @Route("/{id}", name="exchange_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KrsStateBundle:Exchange')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Exchange entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('exchange'));
    }

    /**
     * Creates a form to delete a Exchange entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('exchange_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
