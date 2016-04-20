<?php

namespace Tesseract\MOOCBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tesseract\MOOCBundle\Entity\BanForum;
use Tesseract\MOOCBundle\Form\BanForumType;

/**
 * BanForum controller.
 *
 * @Route("/banforum")
 */
class BanForumController extends Controller
{

    /**
     * Lists all BanForum entities.
     *
     * @Route("/", name="banforum")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TesseractMOOCBundle:BanForum')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new BanForum entity.
     *
     * @Route("/", name="banforum_create")
     * @Method("POST")
     * @Template("TesseractMOOCBundle:BanForum:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new BanForum();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('banforum_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a BanForum entity.
     *
     * @param BanForum $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(BanForum $entity)
    {
        $form = $this->createForm(new BanForumType(), $entity, array(
            'action' => $this->generateUrl('banforum_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new BanForum entity.
     *
     * @Route("/new", name="banforum_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new BanForum();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a BanForum entity.
     *
     * @Route("/{id}", name="banforum_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TesseractMOOCBundle:BanForum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BanForum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BanForum entity.
     *
     * @Route("/{id}/edit", name="banforum_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TesseractMOOCBundle:BanForum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BanForum entity.');
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
    * Creates a form to edit a BanForum entity.
    *
    * @param BanForum $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(BanForum $entity)
    {
        $form = $this->createForm(new BanForumType(), $entity, array(
            'action' => $this->generateUrl('banforum_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing BanForum entity.
     *
     * @Route("/{id}", name="banforum_update")
     * @Method("PUT")
     * @Template("TesseractMOOCBundle:BanForum:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TesseractMOOCBundle:BanForum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BanForum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('banforum_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a BanForum entity.
     *
     * @Route("/{id}", name="banforum_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TesseractMOOCBundle:BanForum')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BanForum entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('banforum'));
    }

    /**
     * Creates a form to delete a BanForum entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('banforum_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
