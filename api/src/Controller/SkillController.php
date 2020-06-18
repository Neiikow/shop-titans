<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class SkillController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/skill/create",
     *    name = "skill_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("skill", converter="fos_rest.request_body")
     */
    public function create(Skill $skill, ConstraintViolationList $violations)
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

        $skill = $er->createOneToOne($em, $skill, "prevTier", "Skill");

        $em->persist($skill);
        $em->flush();

        return $this->view(
            $skill,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'skill_id',
                ['id' => $skill->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/skill/update/{id}",
     *    name = "skill_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("skill", converter="fos_rest.request_body")
     */
    public function update($id, Skill $skill, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Skill::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Compétence introuvable'
            );
        }

        $data->setName($skill->getName());
        $data->setImg($skill->getImg());
        $data->setDescription($skill->getDescription());
        $data->setType($skill->getType());
        $data->setRarity($skill->getRarity());
        $data->setTier($skill->getTier());
        $data->setElementCost($skill->getElementCost());
        $data->setEffect($skill->getEffect());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/skill/delete/{id}",
     *    name = "skill_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $skill = $em->getRepository(Skill::class)->find($id);

        if (!$skill) {
            throw $this->createNotFoundException(
                'Compétence introuvable'
            );
        }

        $em->remove($skill);
        $em->flush();

        return $skill;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/skill/{id}",
     *    name = "skill_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $skill = $em->getRepository(Skill::class)->find($id);

        if (!$skill) {
            throw $this->createNotFoundException(
                'Compétence introuvable'
            );
        }
        return $skill;
    }

    /**
     * @Rest\Get(
     *    path = "/api/skill",
     *    name = "skill_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $skill = $this->getDoctrine()->getRepository('App:Skill')->findAll();

        return $skill;
    }
}
