<?php

namespace Kan\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kan\CmsBundle\Entity\Page;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;


class DefaultController extends Controller
{
    public function indexAction($id)
    {
        $page = $this->getDoctrine()
            ->getRepository('KanCmsBundle:Page')
            ->find($id);

        if (!$page) {
            throw $this->createNotFoundException(
                'No product found for id '. $id
            );
        }

        return $this->render('KanCmsBundle:Default:index.html.twig', array(
            'page' => $page,
            'created' => $page->getCreated()->format('Y-m-d H:i:s'),
            'edited' => $page->getEdited()->format('Y-m-d H:i:s'),
        ));
    }

    public function createAction()
    {
        $page = new Page();
        $title = 'Kan page 1';
        $description = 'Test page description';
        $created = $edited = new \DateTime();

        $page->setTitle($title);
        $page->setDescription($description);
        $page->setCreated($created);
        $page->setEdited($edited);

        $em = $this->getDoctrine()->getManager();
        $em->persist($page);
        $em->flush();

        return $this->render('KanCmsBundle:Default:create.html.twig', array(
            'page' => $page,
            'created' => $page->getCreated()->format('Y-m-d H:i:s'),
            'edited' => $page->getEdited()->format('Y-m-d H:i:s'),
        ));
    }

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('KanCmsBundle:Page')
            ->find($id);

        if (!$page) {
            throw $this->createNotFoundException(
                'No product found for id '. $id
            );
        }

        $page->setTitle('updated title');

        $em->flush();

        return $this->render('KanCmsBundle:Default:update.html.twig', array(
            'page' => $page,
            'created' => $page->getCreated()->format('Y-m-d H:i:s'),
            'edited' => $page->getEdited()->format('Y-m-d H:i:s'),
        ));
    }
}
