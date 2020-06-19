<?php

namespace App\Controller;

use App\Entity\Furniture;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class FurnitureController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/furniture/create",
     *    name = "furniture_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("furniture", converter="fos_rest.request_body")
     */
    public function create(Furniture $furniture, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = "Données reçues non valides :";
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $er = new EntityRelation;

        $er->createManyToOne($em, $furniture, "type", "FurnitureType");
        
        $em->persist($furniture);
        $em->flush();

        return $this->view(
            $furniture,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'furniture_id',
                ['id' => $furniture->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/furniture/update/{id}",
     *    name = "furniture_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("furniture", converter="fos_rest.request_body")
     */
    public function update($id, Furniture $furniture, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $er = new EntityRelation;
        $data = $em->getRepository(Furniture::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Meuble introuvable'
            );
        }

        $er->createManyToOne($em, $furniture, "type", "FurnitureType", $data);

        $data->setName($furniture->getName());
        $data->setImg($furniture->getImg());
        $data->setGoldCosts($furniture->getGoldCosts());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/furniture/delete/{id}",
     *    name = "furniture_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $furniture = $em->getRepository(Furniture::class)->find($id);

        if (!$furniture) {
            throw $this->createNotFoundException(
                'Meuble introuvable'
            );
        }

        $em->remove($furniture);
        $em->flush();

        return $furniture;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/furniture/{id}",
     *    name = "furniture_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $furniture = $em->getRepository(Furniture::class)->find($id);

        if (!$furniture) {
            throw $this->createNotFoundException(
                'Meuble introuvable'
            );
        }
        return $furniture;
    }

    /**
     * @Rest\Get(
     *    path = "/api/furniture",
     *    name = "furniture_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $furniture = $this->getDoctrine()->getRepository('App:Furniture')->findAll();

        return $furniture;
    }
}