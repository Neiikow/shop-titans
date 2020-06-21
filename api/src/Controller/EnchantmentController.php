<?php

namespace App\Controller;

use App\Entity\Enchantment;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class EnchantmentController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/enchantment/create",
     *    name = "enchantment_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("enchantment", converter="fos_rest.request_body")
     */
    public function create(Enchantment $enchantment, ConstraintViolationList $violations)
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

        $er->createManyToOne($em, $enchantment, "type", "ItemType");

        $em->persist($enchantment);
        $em->flush();

        return $this->view(
            $enchantment,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'enchantment_id',
                ['id' => $enchantment->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/enchantment/update/{id}",
     *    name = "enchantment_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("enchantment", converter="fos_rest.request_body")
     */
    public function update($id, Enchantment $enchantment, ConstraintViolationList $violations)
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
        $data = $em->getRepository(Enchantment::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Enchantement introuvable'
            );
        }

        $er->createManyToOne($em, $enchantment, "type", "ItemType", $data);

        $data->setEffect($enchantment->getEffect());
        $data->setImg($enchantment->getImg());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/enchantment/delete/{id}",
     *    name = "enchantment_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $enchantment = $em->getRepository(Enchantment::class)->find($id);

        if (!$enchantment) {
            throw $this->createNotFoundException(
                'Enchantement introuvable'
            );
        }

        $em->remove($enchantment);
        $em->flush();

        return $enchantment;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/enchantment/{id}",
     *    name = "enchantment_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $enchantment = $em->getRepository(Enchantment::class)->find($id);

        if (!$enchantment) {
            throw $this->createNotFoundException(
                'Enchantement introuvable'
            );
        }
        return $enchantment;
    }

    /**
     * @Rest\Get(
     *    path = "/api/enchantment",
     *    name = "enchantment_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $enchantment = $this->getDoctrine()->getRepository('App:Enchantment')->findAll();

        return $enchantment;
    }
}
