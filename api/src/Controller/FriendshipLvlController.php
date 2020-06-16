<?php

namespace App\Controller;

use App\Entity\FriendshipLvl;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class FriendshipLvlController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/friendship/lvl/create",
     *    name = "friendshipLvl_create"
     * )
     * @Rest\View
     * @ParamConverter("lvl", converter="fos_rest.request_body")
     */
    public function create(FriendshipLvl $lvl, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($lvl);
        $em->flush();

        return $this->view(
            $lvl,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'friendshipLvl_id',
                ['id' => $lvl->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/friendship/lvl/update/{id}",
     *    name = "friendshipLvl_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("lvl", converter="fos_rest.request_body")
     */
    public function update($id, FriendshipLvl $lvl, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(FriendshipLvl::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }

        $data->setLvl($lvl->getLvl());
        $data->setRankName($lvl->getRankName());
        $data->setNrgBonus($lvl->getNrgBonus());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/friendship/lvl/delete/{id}",
     *    name = "friendshipLvl_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $lvl = $em->getRepository(FriendshipLvl::class)->find($id);

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
     *    path = "/api/friendship/lvl/{id}",
     *    name = "friendshipLvl_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $lvl = $em->getRepository(FriendshipLvl::class)->find($id);

        if (!$lvl) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }
        return $lvl;
    }

    /**
     * @Rest\Get(
     *    path = "/api/friendship/lvl",
     *    name = "friendshipLvl_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $lvl = $this->getDoctrine()->getRepository('App:FriendshipLvl')->findAll();

        return $lvl;
    }
}
