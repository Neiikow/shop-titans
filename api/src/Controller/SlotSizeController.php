<?php

namespace App\Controller;

use App\Entity\SlotSize;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class SlotSizeController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/slot/size/create",
     *    name = "slotSize_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("size", converter="fos_rest.request_body")
     */
    public function create(SlotSize $size, ConstraintViolationList $violations)
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

        $er->createManyToOne($em, $size, "slot", "Slot");
        
        $em->persist($size); 
        $em->flush();

        return $this->view(
            $size,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'slotSize_id',
                ['id' => $size->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/slot/size/update/{id}",
     *    name = "slotSize_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("size", converter="fos_rest.request_body")
     */
    public function update($id, SlotSize $size, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(SlotSize::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Taille introuvable'
            );
        }

        $data->setSize($size->getSize());
        $data->setPrerequisite($size->getPrerequisite());
        $data->setGoldCost($size->getGoldCost());
        $data->setGemCost($size->getGemCost());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/slot/size/delete/{id}",
     *    name = "slotSize_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $size = $em->getRepository(SlotSize::class)->find($id);

        if (!$size) {
            throw $this->createNotFoundException(
                'Taille introuvable'
            );
        }

        $em->remove($size);
        $em->flush();

        return $size;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/slot/size/{id}",
     *    name = "slotSize_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $size = $em->getRepository(SlotSize::class)->find($id);

        if (!$size) {
            throw $this->createNotFoundException(
                'Taille introuvable'
            );
        }
        return $size;
    }

    /**
     * @Rest\Get(
     *    path = "/api/slot/size",
     *    name = "slotSize_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $size = $this->getDoctrine()->getRepository('App:SlotSize')->findAll();

        return $size;
    }
}
