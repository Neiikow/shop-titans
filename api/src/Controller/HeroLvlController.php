<?php

namespace App\Controller;

use App\Entity\HeroLvl;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class HeroLvlController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/hero/lvl/create",
     *    name = "heroLvl_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("lvl", converter="fos_rest.request_body")
     */
    public function create(HeroLvl $lvl, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($lvl);
        $em->flush();

        return $this->view(
            $lvl,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'heroLvl_id',
                ['id' => $lvl->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/hero/lvl/update/{id}",
     *    name = "heroLvl_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("lvl", converter="fos_rest.request_body")
     */
    public function update($id, HeroLvl $lvl, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(HeroLvl::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }

        $data->setLvl($lvl->getLvl());
        $data->setXpNeeded($lvl->getXpNeeded());
        $data->setItemTier($lvl->getItemTier());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/hero/lvl/delete/{id}",
     *    name = "heroLvl_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $lvl = $em->getRepository(HeroLvl::class)->find($id);

        if (!$lvl) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }

        $em->remove($lvl);
        $em->flush();

        return $lvl;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/hero/lvl/{id}",
     *    name = "heroLvl_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $lvl = $em->getRepository(HeroLvl::class)->find($id);

        if (!$lvl) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }
        return $lvl;
    }

    /**
     * @Rest\Get(
     *    path = "/api/hero/lvl",
     *    name = "heroLvl_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $lvl = $this->getDoctrine()->getRepository('App:HeroLvl')->findAll();

        return $lvl;
    }
}
