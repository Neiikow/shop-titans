<?php

namespace App\Controller;

use App\Entity\QuestBoss;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class QuestBossController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/quest/boss/create",
     *    name = "questBoss_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("boss", converter="fos_rest.request_body")
     */
    public function create(QuestBoss $boss, ConstraintViolationList $violations)
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

        $er->createOneToOne($em, $boss, "area", "QuestArea");
        
        $em->persist($boss);
        $em->flush();

        return $this->view(
            $boss,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'questBoss_id',
                ['id' => $boss->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/quest/boss/update/{id}",
     *    name = "questBoss_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("boss", converter="fos_rest.request_body")
     */
    public function update($id, QuestBoss $boss, ConstraintViolationList $violations)
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
        $data = $em->getRepository(QuestBoss::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Boss introuvable'
            );
        }

        $er->createOneToOne($em, $boss, "area", "QuestArea", $data);

        $data->setName($boss->getName());
        $data->setImg($boss->getImg());
        $data->setHealTime($boss->getHealTime());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/quest/boss/delete/{id}",
     *    name = "questBoss_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $boss = $em->getRepository(QuestBoss::class)->find($id);

        if (!$boss) {
            throw $this->createNotFoundException(
                'Boss introuvable'
            );
        }

        $em->remove($boss);
        $em->flush();

        return $boss;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/quest/boss/{id}",
     *    name = "questBoss_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $boss = $em->getRepository(QuestBoss::class)->find($id);

        if (!$boss) {
            throw $this->createNotFoundException(
                'Boss introuvable'
            );
        }
        return $boss;
    }

    /**
     * @Rest\Get(
     *    path = "/api/quest/boss",
     *    name = "questBoss_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $boss = $this->getDoctrine()->getRepository('App:QuestBoss')->findAll();

        return $boss;
    }
}