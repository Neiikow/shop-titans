<?php

namespace App\Controller;

use App\Entity\GuildPerk;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class GuildPerkController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/guild/perk/create",
     *    name = "guildPerk_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("perk", converter="fos_rest.request_body")
     */
    public function create(GuildPerk $perk, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($perk);
        $em->flush();

        return $this->view(
            $perk,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'guildPerk_id',
                ['id' => $perk->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/guild/perk/update/{id}",
     *    name = "guildPerk_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("perk", converter="fos_rest.request_body")
     */
    public function update($id, GuildPerk $perk, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(GuildPerk::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Atout introuvable'
            );
        }

        $data->setName($perk->getName());
        $data->setImg($perk->getImg());
        $data->setDescription($perk->getDescription());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/guild/perk/delete/{id}",
     *    name = "guildPerk_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $perk = $em->getRepository(GuildPerk::class)->find($id);

        if (!$perk) {
            throw $this->createNotFoundException(
                'Atout introuvable'
            );
        }

        $em->remove($perk);
        $em->flush();

        return $perk;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/guild/perk/{id}",
     *    name = "guildPerk_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $perk = $em->getRepository(GuildPerk::class)->find($id);

        if (!$perk) {
            throw $this->createNotFoundException(
                'Atout introuvable'
            );
        }
        return $perk;
    }

    /**
     * @Rest\Get(
     *    path = "/api/guild/perk",
     *    name = "guildPerk_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $perk = $this->getDoctrine()->getRepository('App:GuildPerk')->findAll();

        return $perk;
    }
}
