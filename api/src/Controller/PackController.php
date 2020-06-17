<?php

namespace App\Controller;

use App\Entity\Pack;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class PackController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/pack/create",
     *    name = "pack_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("pack", converter="fos_rest.request_body")
     */
    public function create(Pack $pack, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($pack);
        $em->flush();

        return $this->view(
            $pack,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'pack_id',
                ['id' => $pack->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/pack/update/{id}",
     *    name = "pack_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("pack", converter="fos_rest.request_body")
     */
    public function update($id, Pack $pack, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Pack::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Pack introuvable'
            );
        }

        $data->setName($pack->getName());
        $data->setImg($pack->getImg());
        $data->setDescription($pack->getDescription());
        $data->setReleaseDate($pack->getReleaseDate());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/pack/delete/{id}",
     *    name = "pack_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $pack = $em->getRepository(Pack::class)->find($id);

        if (!$pack) {
            throw $this->createNotFoundException(
                'Pack introuvable'
            );
        }

        $em->remove($pack);
        $em->flush();

        return $pack;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/pack/{id}",
     *    name = "pack_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $pack = $em->getRepository(Pack::class)->find($id);

        if (!$pack) {
            throw $this->createNotFoundException(
                'Pack introuvable'
            );
        }
        return $pack;
    }

    /**
     * @Rest\Get(
     *    path = "/api/pack",
     *    name = "pack_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $pack = $this->getDoctrine()->getRepository('App:Pack')->findAll();

        return $pack;
    }
}