<?php

namespace App\Controller;

use App\Entity\QuestArea;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class QuestAreaController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/quest/area/create",
     *    name = "questArea_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("area", converter="fos_rest.request_body")
     */
    public function create(QuestArea $area, ConstraintViolationList $violations)
    {

        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();        
        $em->persist($area);
        $em->flush();

        return $this->view(
            $area,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'questArea_id',
                ['id' => $area->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/quest/area/update/{id}",
     *    name = "questArea_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("area", converter="fos_rest.request_body")
     */
    public function update($id, QuestArea $area, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(QuestArea::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Zone introuvable'
            );
        }

        $data->setName($area->getName());
        $data->setImg($area->getImg());
        $data->setPartySize($area->getPartySize());
        $data->setGoldCost($area->getGoldCost());
        $data->setGemCost($area->getGemCost());
        $data->setPrerequisite($area->getPrerequisite());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/quest/area/delete/{id}",
     *    name = "questArea_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $area = $em->getRepository(QuestArea::class)->find($id);

        if (!$area) {
            throw $this->createNotFoundException(
                'Zone introuvable'
            );
        }

        $em->remove($area);
        $em->flush();

        return $area;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/quest/area/{id}",
     *    name = "questArea_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $area = $em->getRepository(QuestArea::class)->find($id);

        if (!$area) {
            throw $this->createNotFoundException(
                'Zone introuvable'
            );
        }
        return $area;
    }

    /**
     * @Rest\Get(
     *    path = "/api/quest/area",
     *    name = "questArea_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $area = $this->getDoctrine()->getRepository('App:QuestArea')->findAll();

        return $area;
    }
}