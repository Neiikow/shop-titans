<?php

namespace App\Controller;

use App\Entity\Slot;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class SlotController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/slot/create",
     *    name = "slot_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("slot", converter="fos_rest.request_body")
     */
    public function create(Slot $slot, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($slot);
        $em->flush();

        return $this->view(
            $slot,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'slot_id',
                ['id' => $slot->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/slot/update/{id}",
     *    name = "slot_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("slot", converter="fos_rest.request_body")
     */
    public function update($id, Slot $slot, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Slot::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Slot introuvable'
            );
        }

        $data->setName($slot->getName());
        $data->setImg($slot->getImg());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/slot/delete/{id}",
     *    name = "slot_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $slot = $em->getRepository(Slot::class)->find($id);

        if (!$slot) {
            throw $this->createNotFoundException(
                'Slot introuvable'
            );
        }

        $em->remove($slot);
        $em->flush();

        return $slot;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/slot/{id}",
     *    name = "slot_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $slot = $em->getRepository(Slot::class)->find($id);

        if (!$slot) {
            throw $this->createNotFoundException(
                'Slot introuvable'
            );
        }
        return $slot;
    }

    /**
     * @Rest\Get(
     *    path = "/api/slot",
     *    name = "slot_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $slot = $this->getDoctrine()->getRepository('App:Slot')->findAll();

        return $slot;
    }
}
