<?php

namespace App\Controller;

use App\Entity\ShopExpansion;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class ShopExpansionController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/shop/expansion/create",
     *    name = "shopExpansion_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("expansion", converter="fos_rest.request_body")
     */
    public function create(ShopExpansion $expansion, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($expansion);
        $em->flush();

        return $this->view(
            $expansion,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'shopExpansion_id',
                ['id' => $expansion->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/shop/expansion/update/{id}",
     *    name = "shopExpansion_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("expansion", converter="fos_rest.request_body")
     */
    public function update($id, ShopExpansion $expansion, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(ShopExpansion::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Expansion introuvable'
            );
        }

        $data->setTier($expansion->getTier());
        $data->setSize($expansion->getSize());
        $data->setFurnitureIncrease($expansion->getFurnitureIncrease());
        $data->setPrerequisite($expansion->getPrerequisite());
        $data->setGoldCost($expansion->getGoldCost());
        $data->setGemCost($expansion->getGemCost());
        $data->setConstructTime($expansion->getConstructTime());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/shop/expansion/delete/{id}",
     *    name = "shopExpansion_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $expansion = $em->getRepository(ShopExpansion::class)->find($id);

        if (!$expansion) {
            throw $this->createNotFoundException(
                'Expansion introuvable'
            );
        }

        $em->remove($expansion);
        $em->flush();

        return $expansion;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/shop/expansion/{id}",
     *    name = "shopExpansion_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $expansion = $em->getRepository(ShopExpansion::class)->find($id);

        if (!$expansion) {
            throw $this->createNotFoundException(
                'Expansion introuvable'
            );
        }
        return $expansion;
    }

    /**
     * @Rest\Get(
     *    path = "/api/shop/expansion",
     *    name = "shopExpansion_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $expansion = $this->getDoctrine()->getRepository('App:ShopExpansion')->findAll();

        return $expansion;
    }
}
