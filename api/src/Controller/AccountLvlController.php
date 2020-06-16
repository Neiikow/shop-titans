<?php

namespace App\Controller;

use App\Entity\AccountLvl;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class AccountLvlController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/account/lvl/create",
     *    name = "accountLvl_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("lvl", converter="fos_rest.request_body")
     */
    public function create(AccountLvl $lvl, ConstraintViolationList $violations)
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
                'accountLvl_id',
                ['id' => $lvl->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/account/lvl/update/{id}",
     *    name = "accountLvl_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("lvl", converter="fos_rest.request_body")
     */
    public function update($id, AccountLvl $lvl, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(AccountLvl::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }

        $data->setLvl($lvl->getLvl());
        $data->setXpNeeded($lvl->getXpNeeded());
        $data->setGemReward($lvl->getGemReward());
        $data->setMarketTier($lvl->getMarketTier());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/account/lvl/delete/{id}",
     *    name = "accountLvl_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $lvl = $em->getRepository(AccountLvl::class)->find($id);

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
     *    path = "/api/account/lvl/{id}",
     *    name = "accountLvl_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $lvl = $em->getRepository(AccountLvl::class)->find($id);

        if (!$lvl) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }
        return $lvl;
    }

    /**
     * @Rest\Get(
     *    path = "/api/account/lvl",
     *    name = "accountLvl_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $lvl = $this->getDoctrine()->getRepository('App:AccountLvl')->findAll();

        return $lvl;
    }
}
