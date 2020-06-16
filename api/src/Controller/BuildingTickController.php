<?php

namespace App\Controller;

use App\Entity\BuildingTick;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class BuildingTickController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/building/tick/create",
     *    name = "buildingTick_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("tick", converter="fos_rest.request_body")
     */
    public function create(BuildingTick $tick, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($tick);
        $em->flush();

        return $this->view(
            $tick,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'buildingTick_id',
                ['id' => $tick->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/building/tick/update/{id}",
     *    name = "buildingTick_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("tick", converter="fos_rest.request_body")
     */
    public function update($id, BuildingTick $tick, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(BuildingTick::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Données des ticks introuvables'
            );
        }

        $data->setTier($tick->getTier());
        $data->setTick($tick->getTick());
        $data->setGoldPerTick($tick->getGoldPerTick());
        $data->setGemPerTick($tick->getGemPerTick());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/building/tick/delete/{id}",
     *    name = "buildingTick_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tick = $em->getRepository(BuildingTick::class)->find($id);

        if (!$tick) {
            throw $this->createNotFoundException(
                'Données des ticks introuvables'
            );
        }

        $em->remove($tick);
        $em->flush();

        return $tick;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/building/tick/{id}",
     *    name = "buildingTick_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tick = $em->getRepository(BuildingTick::class)->find($id);

        if (!$tick) {
            throw $this->createNotFoundException(
                'Données des ticks introuvables'
            );
        }
        return $tick;
    }

    /**
     * @Rest\Get(
     *    path = "/api/building/tick",
     *    name = "buildingTick_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $tick = $this->getDoctrine()->getRepository('App:BuildingTick')->findAll();

        return $tick;
    }
}
