<?php

namespace App\Controller;

use App\Entity\Rarity;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class RarityController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/rarity/create",
     *    name = "rarity_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("rarity", converter="fos_rest.request_body")
     */
    public function create(Rarity $rarity, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($rarity);
        $em->flush();

        return $this->view(
            $rarity,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'rarity_id',
                ['id' => $rarity->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/rarity/update/{id}",
     *    name = "rarity_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("rarity", converter="fos_rest.request_body")
     */
    public function update($id, Rarity $rarity, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Rarity::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Rareté introuvable'
            );
        }

        $data->setName($rarity->getName());
        $data->setImg($rarity->getImg());
        $data->setColor($rarity->getColor());
        $data->setTier($rarity->getTier());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/rarity/delete/{id}",
     *    name = "rarity_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $rarity = $em->getRepository(Rarity::class)->find($id);

        if (!$rarity) {
            throw $this->createNotFoundException(
                'Rareté introuvable'
            );
        }

        $em->remove($rarity);
        $em->flush();

        return $rarity;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/rarity/{id}",
     *    name = "rarity_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $rarity = $em->getRepository(Rarity::class)->find($id);

        if (!$rarity) {
            throw $this->createNotFoundException(
                'Rareté introuvable'
            );
        }
        return $rarity;
    }

    /**
     * @Rest\Get(
     *    path = "/api/rarity",
     *    name = "rarity_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $rarity = $this->getDoctrine()->getRepository('App:Rarity')->findAll();

        return $rarity;
    }
}
