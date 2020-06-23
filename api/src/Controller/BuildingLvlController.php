<?php

namespace App\Controller;

use App\Entity\BuildingLvl;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class BuildingLvlController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/building/lvl/create",
     *    name = "buildingLvl_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("lvl", converter="fos_rest.request_body")
     */
    public function create(BuildingLvl $lvl, ConstraintViolationList $violations)
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

        $er->createManyToOne($em, $lvl, "building", "Building");
        
        $em->persist($lvl);
        $em->flush();

        return $this->view(
            $lvl,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'buildingLvl_id',
                ['id' => $lvl->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/building/lvl/update/{id}",
     *    name = "buildingLvl_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("lvl", converter="fos_rest.request_body")
     */
    public function update($id, BuildingLvl $lvl, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(BuildingLvl::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }

        $data->setLvl($lvl->getLvl());
        $data->setTickNeeded($lvl->getTickNeeded());
        $data->setEffect($lvl->getEffect());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/building/lvl/delete/{id}",
     *    name = "buildingLvl_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $lvl = $em->getRepository(BuildingLvl::class)->find($id);

        if (!$lvl) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }

        $em->remove($lvl);
        $em->flush();

        return $lvl;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/building/lvl/{id}",
     *    name = "buildingLvl_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $lvl = $em->getRepository(BuildingLvl::class)->find($id);

        if (!$lvl) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }
        return $lvl;
    }

    /**
     * @Rest\Get(
     *    path = "/api/building/lvl",
     *    name = "buildingLvl_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $lvl = $this->getDoctrine()->getRepository('App:BuildingLvl')->findAll();

        return $lvl;
    }
}