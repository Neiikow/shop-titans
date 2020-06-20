<?php

namespace App\Controller;

use App\Entity\QuestLvl;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class QuestLvlController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/quest/lvl/create",
     *    name = "questLvl_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("lvl", converter="fos_rest.request_body")
     */
    public function create(QuestLvl $lvl, ConstraintViolationList $violations)
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

        $er->createManyToOne($em, $lvl, "area", "QuestArea");
        
        $em->persist($lvl);
        $em->flush();

        return $this->view(
            $lvl,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'questLvl_id',
                ['id' => $lvl->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/quest/lvl/update/{id}",
     *    name = "questLvl_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("lvl", converter="fos_rest.request_body")
     */
    public function update($id, QuestLvl $lvl, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(QuestLvl::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }

        $data->setLvl($lvl->getLvl());
        $data->setEffect($lvl->getEffect());
        $data->setXpNeeded($lvl->getXpNeeded());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/quest/lvl/delete/{id}",
     *    name = "questLvl_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $lvl = $em->getRepository(QuestLvl::class)->find($id);

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
     *    path = "/api/quest/lvl/{id}",
     *    name = "questLvl_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $lvl = $em->getRepository(QuestLvl::class)->find($id);

        if (!$lvl) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }
        return $lvl;
    }

    /**
     * @Rest\Get(
     *    path = "/api/quest/lvl",
     *    name = "questLvl_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $lvl = $this->getDoctrine()->getRepository('App:QuestLvl')->findAll();

        return $lvl;
    }
}