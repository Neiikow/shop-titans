<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class ChampionController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/champion/create",
     *    name = "champion_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("champion", converter="fos_rest.request_body")
     */
    public function create(Champion $champion, ConstraintViolationList $violations)
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

        $er->createOneToOne($em, $champion, 'leader', 'Character');

        $em->persist($champion);
        $em->flush();

        return $this->view(
            $champion,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'champion_id',
                ['id' => $champion->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/champion/update/{id}",
     *    name = "champion_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("champion", converter="fos_rest.request_body")
     */
    public function update($id, Champion $champion, ConstraintViolationList $violations)
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
        $data = $em->getRepository(Champion::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Champion introuvable'
            );
        }

        $er->createOneToOne($em, $champion, 'leader', 'Character', $data);

        $data->setDescription($champion->getDescription());
        $data->setTitle($champion->getTitle());
        $data->setCoinCost($champion->getCoinCost());
        $data->setHp($champion->getHp());
        $data->setAtk($champion->getAtk());
        $data->setDef($champion->getDef());
        $data->setEva($champion->getEva());
        $data->setCritRate($champion->getCritRate());
        $data->setCritDmg($champion->getCritDmg());
        $data->setThreat($champion->getThreat());
        $data->setPrerequisite($champion->getPrerequisite());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/champion/delete/{id}",
     *    name = "champion_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $champion = $em->getRepository(Champion::class)->find($id);

        if (!$champion) {
            throw $this->createNotFoundException(
                'Champion introuvable'
            );
        }

        $em->remove($champion);
        $em->flush();

        return $champion;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/champion/{id}",
     *    name = "champion_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $champion = $em->getRepository(Champion::class)->find($id);

        if (!$champion) {
            throw $this->createNotFoundException(
                'Champion introuvable'
            );
        }
        return $champion;
    }

    /**
     * @Rest\Get(
     *    path = "/api/champion",
     *    name = "champion_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $champion = $this->getDoctrine()->getRepository('App:Champion')->findAll();

        return $champion;
    }
}