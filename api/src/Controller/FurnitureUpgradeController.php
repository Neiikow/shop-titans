<?php

namespace App\Controller;

use App\Entity\FurnitureUpgrade;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class FurnitureUpgradeController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/furniture/upgrade/create",
     *    name = "furnitureUpgrade_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("upgrade", converter="fos_rest.request_body")
     */
    public function create(FurnitureUpgrade $upgrade, ConstraintViolationList $violations)
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

        $er->createManyToOne($em, $upgrade, "furniture", "Furniture");
        
        $em->persist($upgrade);
        $em->flush();
        
        return $this->view(
            $upgrade,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'furnitureUpgrade_id',
                ['id' => $upgrade->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/furniture/upgrade/update/{id}",
     *    name = "furnitureUpgrade_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("upgrade", converter="fos_rest.request_body")
     * 
     */
    public function update($id, FurnitureUpgrade $upgrade, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(FurnitureUpgrade::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Upgrade introuvable'
            );
        }

        $data->setLvl($upgrade->getLvl());
        $data->setSize($upgrade->getSize());
        $data->setGoldCost($upgrade->getGoldCost());
        $data->setGemCost($upgrade->getGemCost());
        $data->setDescription($upgrade->getDescription());
        $data->setEffects($upgrade->getEffects());
        $data->setTime($upgrade->getTime());
        $data->setPrerequisite($upgrade->getPrerequisite());
        $data->setAccountLvl($upgrade->getAccountLvl());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/furniture/upgrade/delete/{id}",
     *    name = "furnitureUpgrade_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $upgrade = $em->getRepository(FurnitureUpgrade::class)->find($id);

        if (!$upgrade) {
            throw $this->createNotFoundException(
                'Upgrade introuvable'
            );
        }

        $em->remove($upgrade);
        $em->flush();

        return $upgrade;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/furniture/upgrade/{id}",
     *    name = "furnitureUpgrade_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $upgrade = $em->getRepository(FurnitureUpgrade::class)->find($id);

        if (!$upgrade) {
            throw $this->createNotFoundException(
                'Upgrade introuvable'
            );
        }
        return $upgrade;
    }

    /**
     * @Rest\Get(
     *    path = "/api/furniture/upgrade",
     *    name = "furnitureUpgrade_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $upgrade = $this->getDoctrine()->getRepository('App:FurnitureUpgrade')->findAll();

        return $upgrade;
    }
}