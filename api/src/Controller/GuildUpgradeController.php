<?php

namespace App\Controller;

use App\Entity\GuildUpgrade;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class GuildUpgradeController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/guild/upgrade/create",
     *    name = "guildUpgrade_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("upgrade", converter="fos_rest.request_body")
     */
    public function create(GuildUpgrade $upgrade, ConstraintViolationList $violations)
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

        $er->createManyToOne($em, $upgrade, "perk", "GuildPerk");
        $er->createManyToOne($em, $upgrade, "boost", "GuildBoost");
        
        $em->persist($upgrade);
        $em->flush();

        return $this->view(
            $upgrade,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'guildUpgrade_id',
                ['id' => $upgrade->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/guild/upgrade/update/{id}",
     *    name = "guildUpgrade_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("upgrade", converter="fos_rest.request_body")
     */
    public function update($id, GuildUpgrade $upgrade, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(GuildUpgrade::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }

        $data->setLvl($upgrade->getLvl());
        $data->setPrerequisite($upgrade->getPrerequisite());
        $data->setRenowmCost($upgrade->getRenowmCost());
        $data->setEffect($upgrade->getEffect());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/guild/upgrade/delete/{id}",
     *    name = "guildUpgrade_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $upgrade = $em->getRepository(GuildUpgrade::class)->find($id);

        if (!$upgrade) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }

        $em->remove($upgrade);
        $em->flush();

        return $upgrade;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/guild/upgrade/{id}",
     *    name = "guildUpgrade_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $upgrade = $em->getRepository(GuildUpgrade::class)->find($id);

        if (!$upgrade) {
            throw $this->createNotFoundException(
                'Niveau introuvable'
            );
        }
        return $upgrade;
    }

    /**
     * @Rest\Get(
     *    path = "/api/guild/upgrade",
     *    name = "guildUpgrade_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $upgrade = $this->getDoctrine()->getRepository('App:GuildUpgrade')->findAll();

        return $upgrade;
    }
}