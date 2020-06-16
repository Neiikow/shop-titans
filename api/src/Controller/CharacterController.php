<?php

namespace App\Controller;

use App\Entity\Character;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class CharacterController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/character/create",
     *    name = "character_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("character", converter="fos_rest.request_body")
     */
    public function create(Character $character, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($character);
        $em->flush();

        return $this->view(
            $character,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'character_id',
                ['id' => $character->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/character/update/{id}",
     *    name = "character_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("character", converter="fos_rest.request_body")
     */
    public function update($id, Character $character, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Character::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Personnage introuvable'
            );
        }

        $data->setName($character->getName());
        $data->setImg($character->getImg());
        $data->setType($character->getType());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/character/delete/{id}",
     *    name = "character_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $character = $em->getRepository(Character::class)->find($id);

        if (!$character) {
            throw $this->createNotFoundException(
                'Personnage introuvable'
            );
        }

        $em->remove($character);
        $em->flush();

        return $character;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/character/{id}",
     *    name = "character_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $character = $em->getRepository(Character::class)->find($id);

        if (!$character) {
            throw $this->createNotFoundException(
                'Personnage introuvable'
            );
        }
        return $character;
    }

    /**
     * @Rest\Get(
     *    path = "/api/character",
     *    name = "character_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $character = $this->getDoctrine()->getRepository('App:Character')->findAll();

        return $character;
    }
}
