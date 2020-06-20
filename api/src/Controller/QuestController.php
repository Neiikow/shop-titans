<?php

namespace App\Controller;

use App\Entity\Quest;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class QuestController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/quest/create",
     *    name = "quest_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("quest", converter="fos_rest.request_body")
     */
    public function create(Quest $quest, ConstraintViolationList $violations)
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

        $er->createManyToOne($em, $quest, "area", "QuestArea");
        
        $em->persist($quest);
        $em->flush();

        return $this->view(
            $quest,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'quest_id',
                ['id' => $quest->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/quest/update/{id}",
     *    name = "quest_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("quest", converter="fos_rest.request_body")
     */
    public function update($id, Quest $quest, ConstraintViolationList $violations)
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
        $data = $em->getRepository(Quest::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Quête introuvable'
            );
        }

        $er->createManyToOne($em, $quest, "area", "QuestArea", $data);

        $data->setName($quest->getName());
        $data->setDifficulty($quest->getDifficulty());
        $data->setIsBoss($quest->getIsBoss());
        $data->setPowerRequired($quest->getPowerRequired());
        $data->setXp($quest->getXp());
        $data->setQuestTime($quest->getQuestTime());
        $data->setRestTime($quest->getRestTime());
        $data->setHealTime($quest->getHealTime());
        $data->setItemMin($quest->getItemMin());
        $data->setItemMax($quest->getItemMax());
        $data->setMonsterHp($quest->getMonsterHp());
        $data->setMonsterBaseDmg($quest->getMonsterBaseDmg());
        $data->setMonsterAoeDmg($quest->getMonsterAoeDmg());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/quest/delete/{id}",
     *    name = "quest_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $quest = $em->getRepository(Quest::class)->find($id);

        if (!$quest) {
            throw $this->createNotFoundException(
                'Quête introuvable'
            );
        }

        $em->remove($quest);
        $em->flush();

        return $quest;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/quest/{id}",
     *    name = "quest_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $quest = $em->getRepository(Quest::class)->find($id);

        if (!$quest) {
            throw $this->createNotFoundException(
                'Quête introuvable'
            );
        }
        return $quest;
    }

    /**
     * @Rest\Get(
     *    path = "/api/quest",
     *    name = "quest_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $quest = $this->getDoctrine()->getRepository('App:Quest')->findAll();

        return $quest;
    }
}