<?php

namespace App\Controller;

use App\Entity\ItemType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class ItemTypeController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/item/type/create",
     *    name = "itemType_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("type", converter="fos_rest.request_body")
     */
    public function create(ItemType $type, ConstraintViolationList $violations)
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
                'itemType_id',
                ['id' => $type->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/item/type/update/{id}",
     *    name = "itemType_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("type", converter="fos_rest.request_body")
     */
    public function update($id, ItemType $type, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(ItemType::class)->find($id);        

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
     *    path = "/api/admin/item/type/delete/{id}",
     *    name = "itemType_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository(ItemType::class)->find($id);

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
     *    path = "/api/item/type/{id}",
     *    name = "itemType_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository(ItemType::class)->find($id);

        if (!$type) {
            throw $this->createNotFoundException(
                'Type introuvable'
            );
        }
        return $type;
    }

    /**
     * @Rest\Get(
     *    path = "/api/item/type",
     *    name = "itemType_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $type = $this->getDoctrine()->getRepository('App:ItemType')->findAll();

        return $type;
    }
}