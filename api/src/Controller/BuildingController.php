<?php

namespace App\Controller;

use App\Entity\Building;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class BuildingController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/building/create",
     *    name = "building_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("building", converter="fos_rest.request_body")
     */
    public function create(Building $building, ConstraintViolationList $violations)
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

        $er->createOneToOne($em, $building, "owner", "Character");
        
        $em->persist($building);
        $em->flush();

        return $this->view(
            $building,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'building_id',
                ['id' => $building->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/building/update/{id}",
     *    name = "building_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("building", converter="fos_rest.request_body")
     */
    public function update($id, Building $building, ConstraintViolationList $violations)
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
        $data = $em->getRepository(Building::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Bâtiment introuvable'
            );
        }

        $er->createOneToOne($em, $building, "owner", "Character", $data);

        $data->setName($building->getName());
        $data->setImg($building->getImg());
        $data->setDescription($building->getDescription());
        $data->setEffect($building->getEffect());
        $data->setEffectImg($building->getEffectImg());
        $data->setPrerequisite($building->getPrerequisite());
        $data->setTier($building->getTier());
        $data->setGoldCost($building->getGoldCost());
        $data->setGemCost($building->getGemCost());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/building/delete/{id}",
     *    name = "building_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $building = $em->getRepository(Building::class)->find($id);

        if (!$building) {
            throw $this->createNotFoundException(
                'Bâtiment introuvable'
            );
        }

        $em->remove($building);
        $em->flush();

        return $building;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/building/{id}",
     *    name = "building_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $building = $em->getRepository(Building::class)->find($id);

        if (!$building) {
            throw $this->createNotFoundException(
                'Bâtiment introuvable'
            );
        }
        return $building;
    }

    /**
     * @Rest\Get(
     *    path = "/api/building",
     *    name = "building_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $building = $this->getDoctrine()->getRepository('App:Building')->findAll();

        return $building;
    }
}