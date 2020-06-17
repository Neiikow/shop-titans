<?php

namespace App\Controller;

use App\Entity\FurnitureType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class FurnitureTypeController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/furniture/type/create",
     *    name = "furnitureType_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("type", converter="fos_rest.request_body")
     */
    public function create(FurnitureType $type, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($type);
        $em->flush();

        return $this->view(
            $type,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'furnitureType_id',
                ['id' => $type->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/furniture/type/update/{id}",
     *    name = "furnitureType_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("type", converter="fos_rest.request_body")
     */
    public function update($id, FurnitureType $type, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(FurnitureType::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Type introuvable'
            );
        }

        $data->setName($type->getName());
        $data->setImg($type->getImg());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/furniture/type/delete/{id}",
     *    name = "furnitureType_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository(FurnitureType::class)->find($id);

        if (!$type) {
            throw $this->createNotFoundException(
                'Type introuvable'
            );
        }

        $em->remove($type);
        $em->flush();

        return $type;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/furniture/type/{id}",
     *    name = "furnitureType_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository(FurnitureType::class)->find($id);

        if (!$type) {
            throw $this->createNotFoundException(
                'Type introuvable'
            );
        }
        return $type;
    }

    /**
     * @Rest\Get(
     *    path = "/api/furniture/type",
     *    name = "furnitureType_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $type = $this->getDoctrine()->getRepository('App:FurnitureType')->findAll();

        return $type;
    }
}
