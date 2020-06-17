<?php

namespace App\Controller;

use App\Entity\Consumable;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class ConsumableController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/consumable/create",
     *    name = "consumable_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("consumable", converter="fos_rest.request_body")
     */
    public function create(Consumable $consumable, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($consumable);
        $em->flush();

        return $this->view(
            $consumable,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'consumable_id',
                ['id' => $consumable->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/consumable/update/{id}",
     *    name = "consumable_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("consumable", converter="fos_rest.request_body")
     */
    public function update($id, Consumable $consumable, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Consumable::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Consommable introuvable'
            );
        }

        $data->setName($consumable->getName());
        $data->setImg($consumable->getImg());
        $data->setDescription($consumable->getDescription());
        $data->setEffect($consumable->getEffect());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/consumable/delete/{id}",
     *    name = "consumable_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $consumable = $em->getRepository(Consumable::class)->find($id);

        if (!$consumable) {
            throw $this->createNotFoundException(
                'Consommable introuvable'
            );
        }

        $em->remove($consumable);
        $em->flush();

        return $consumable;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/consumable/{id}",
     *    name = "consumable_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $consumable = $em->getRepository(Consumable::class)->find($id);

        if (!$consumable) {
            throw $this->createNotFoundException(
                'Consommable introuvable'
            );
        }
        return $consumable;
    }

    /**
     * @Rest\Get(
     *    path = "/api/consumable",
     *    name = "consumable_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $consumable = $this->getDoctrine()->getRepository('App:Consumable')->findAll();

        return $consumable;
    }
}
