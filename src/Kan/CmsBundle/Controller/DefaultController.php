<?php

namespace Kan\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Kan\CmsBundle\Entity\Page;
use Kan\CmsBundle\Form\PageType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $pages = $this->getDoctrine()
            ->getRepository('KanCmsBundle:Page')
            ->findAll();

        if (!$pages) {
            throw $this->createNotFoundException(
                'No pages found'
            );
        }

        foreach ($pages as &$page) {
            $edited = $page->getEdited()->format('Y-m-d H:i:s');
            $page->setEdited($edited);
            $created = $page->getCreated()->format('Y-m-d H:i:s');
            $page->setCreated($created);
        }

        return $this->render('KanCmsBundle:Default:index.html.twig', array(
            'pages' => $pages,
        ));
    }

    public function showAction($id)
    {
        $page = $this->getDoctrine()
            ->getRepository('KanCmsBundle:Page')
            ->find($id);

        if (!$page) {
            throw $this->createNotFoundException(
                'No pages found for id '. $id
            );
        }

        return $this->render('KanCmsBundle:Default:show.html.twig', array(
                                                                          'page' => $page,
                                                                          'created' => $page->getCreated()->format('Y-m-d H:i:s'),
                                                                          'edited' => $page->getEdited()->format('Y-m-d H:i:s'),
                                                                     ));
    }

    public function createAction(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $page = new Page();

        $form = $this->createForm(new PageType(), $page);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirect($this->generateUrl('kan_cms_index'));
        } else {
            return $this->render(
                'KanCmsBundle:Default:create.html.twig',
                array(
                     'page_form' => $form->createView(),
                )
            );
        }
    }

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('KanCmsBundle:Page')
            ->find($id);

        if (!$page) {
            throw $this->createNotFoundException(
                'No page found for id '. $id
            );
        }

        $form = $this->createFormBuilder($page)
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->add('edited', 'date')
            ->add('save', 'submit')
            ->getForm();

        //@see isSubmitted()
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirect($this->generateUrl('kan_cms_index'));
        }else{
            return $this->render('KanCmsBundle:Default:update.html.twig', array(
                                                                               'page_form' => $form->createView(),
                                                                          ));
        }
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('KanCmsBundle:Page')
            ->find($id);

        if (!$page) {
            throw $this->createNotFoundException(
                'No page found for id '. $id
            );
        }

        $em->remove($page);
        $em->flush();

        return $this->redirect($this->generateUrl('kan_cms_index'));
    }
}
