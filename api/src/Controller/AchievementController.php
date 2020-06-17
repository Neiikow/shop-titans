<?php

namespace App\Controller;

use App\Entity\Achievement;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class AchievementController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/achievement/create",
     *    name = "achievement_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("achievement", converter="fos_rest.request_body")
     */
    public function create(Achievement $achievement, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($achievement);
        $em->flush();

        return $this->view(
            $achievement,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'achievement_id',
                ['id' => $achievement->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/achievement/update/{id}",
     *    name = "achievement_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("achievement", converter="fos_rest.request_body")
     */
    public function update($id, Achievement $achievement, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Achievement::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Succès introuvable'
            );
        }

        $data->setImg($achievement->getImg());
        $data->setTier($achievement->getTier());
        $data->setName($achievement->getName());
        $data->setDescription($achievement->getDescription());
        $data->setGemReward($achievement->getGemReward());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/achievement/delete/{id}",
     *    name = "achievement_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $achievement = $em->getRepository(Achievement::class)->find($id);

        if (!$achievement) {
            throw $this->createNotFoundException(
                'Succès introuvable'
            );
        }

        $em->remove($achievement);
        $em->flush();

        return $achievement;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/achievement/{id}",
     *    name = "achievement_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $achievement = $em->getRepository(Achievement::class)->find($id);

        if (!$achievement) {
            throw $this->createNotFoundException(
                'Succès introuvable'
            );
        }
        return $achievement;
    }

    /**
     * @Rest\Get(
     *    path = "/api/achievement",
     *    name = "achievement_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $achievements = $this->getDoctrine()->getRepository('App:Achievement')->findAll();

        return $achievements;
    }
}
