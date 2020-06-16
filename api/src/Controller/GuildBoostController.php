<?php

namespace App\Controller;

use App\Entity\GuildBoost;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class GuildBoostController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/guild/boost/create",
     *    name = "guildBoost_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("boost", converter="fos_rest.request_body")
     */
    public function create(GuildBoost $boost, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($boost);
        $em->flush();

        return $this->view(
            $boost,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'guildBoost_id',
                ['id' => $boost->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/guild/boost/update/{id}",
     *    name = "guildBoost_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("boost", converter="fos_rest.request_body")
     */
    public function update($id, GuildBoost $boost, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(GuildBoost::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Boost introuvable'
            );
        }

        $data->setName($boost->getName());
        $data->setImg($boost->getImg());
        $data->setBaseDuration($boost->getBaseDuration());
        $data->setRenowmCost($boost->getRenowmCost());
        $data->setEffect($boost->getEffect());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/guild/boost/delete/{id}",
     *    name = "guildBoost_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $boost = $em->getRepository(GuildBoost::class)->find($id);

        if (!$boost) {
            throw $this->createNotFoundException(
                'Boost introuvable'
            );
        }

        $em->remove($boost);
        $em->flush();

        return $boost;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/guild/boost/{id}",
     *    name = "guildBoost_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $boost = $em->getRepository(GuildBoost::class)->find($id);

        if (!$boost) {
            throw $this->createNotFoundException(
                'Boost introuvable'
            );
        }
        return $boost;
    }

    /**
     * @Rest\Get(
     *    path = "/api/guild/boost",
     *    name = "guildBoost_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $boost = $this->getDoctrine()->getRepository('App:GuildBoost')->findAll();

        return $boost;
    }
}
