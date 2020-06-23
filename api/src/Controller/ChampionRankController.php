<?php

namespace App\Controller;

use App\Entity\ChampionRank;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class ChampionRankController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/champion/rank/create",
     *    name = "championRank_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("rank", converter="fos_rest.request_body")
     */
    public function create(ChampionRank $rank, ConstraintViolationList $violations)
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

        $er->createManyToOne($em, $rank, "champion", "Champion");
        $er->createOneToOne($em, $rank, "skillUnlock", "Skill");
        
        $em->persist($rank);
        $em->flush();

        return $this->view(
            $rank,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'championRank_id',
                ['id' => $rank->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/champion/rank/update/{id}",
     *    name = "championRank_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("rank", converter="fos_rest.request_body")
     */
    public function update($id, ChampionRank $rank, ConstraintViolationList $violations)
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
        $data = $em->getRepository(ChampionRank::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Rang introuvable'
            );
        }

        $er->createOneToOne($em, $rank, "skillUnlock", "Skill", $data);

        $data->setRank($rank->getRank());
        $data->setCoinCost($rank->getCoinCost());
        $data->setHpIncrease($rank->getHpIncrease());
        $data->setAtkIncrease($rank->getAtkIncrease());
        $data->setDefIncrease($rank->getDefIncrease());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/champion/rank/delete/{id}",
     *    name = "championRank_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $rank = $em->getRepository(ChampionRank::class)->find($id);

        if (!$rank) {
            throw $this->createNotFoundException(
                'Rang introuvable'
            );
        }

        $em->remove($rank);
        $em->flush();

        return $rank;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/champion/rank/{id}",
     *    name = "championRank_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $rank = $em->getRepository(ChampionRank::class)->find($id);

        if (!$rank) {
            throw $this->createNotFoundException(
                'Rang introuvable'
            );
        }
        return $rank;
    }

    /**
     * @Rest\Get(
     *    path = "/api/champion/rank",
     *    name = "championRank_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $rank = $this->getDoctrine()->getRepository('App:ChampionRank')->findAll();

        return $rank;
    }
}