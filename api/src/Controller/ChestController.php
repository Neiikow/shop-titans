<?php

namespace App\Controller;

use App\Entity\Chest;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class ChestController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/chest/create",
     *    name = "chest_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("chest", converter="fos_rest.request_body")
     */
    public function create(Chest $chest, ConstraintViolationList $violations)
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

        $er->createOneToOne($em, $chest, "openKey", "Consumable");
        $er->createOneToOne($em, $chest, "area", "QuestArea");
        
        $em->persist($chest);
        $em->flush();

        return $this->view(
            $chest,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'chest_id',
                ['id' => $chest->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/chest/update/{id}",
     *    name = "chest_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("chest", converter="fos_rest.request_body")
     */
    public function update($id, Chest $chest, ConstraintViolationList $violations)
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
        $data = $em->getRepository(Chest::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Coffre introuvable'
            );
        }

        $er->createOneToOne($em, $chest, "openKey", "Consumable", $data);
        $er->createOneToOne($em, $chest, "area", "QuestArea", $data);

        $data->setName($chest->getName());
        $data->setImg($chest->getImg());
        $data->setOpenCost($chest->getOpenCost());
        $data->setGoldValue($chest->getGoldValue());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/chest/delete/{id}",
     *    name = "chest_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $chest = $em->getRepository(Chest::class)->find($id);

        if (!$chest) {
            throw $this->createNotFoundException(
                'Coffre introuvable'
            );
        }

        $em->remove($chest);
        $em->flush();

        return $chest;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/chest/{id}",
     *    name = "chest_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $chest = $em->getRepository(Chest::class)->find($id);

        if (!$chest) {
            throw $this->createNotFoundException(
                'Coffre introuvable'
            );
        }
        return $chest;
    }

    /**
     * @Rest\Get(
     *    path = "/api/chest",
     *    name = "chest_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $chest = $this->getDoctrine()->getRepository('App:Chest')->findAll();

        return $chest;
    }
}