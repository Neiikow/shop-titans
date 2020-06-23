<?php

namespace App\Controller;

use App\Entity\Hero;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class HeroController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/hero/create",
     *    name = "hero_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("hero", converter="fos_rest.request_body")
     * 
     */
    public function create(Hero $hero, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($hero);
        $em->flush();

        return $this->view(
            $hero,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'hero_id',
                ['id' => $hero->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/hero/update/{id}",
     *    name = "hero_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("hero", converter="fos_rest.request_body")
     */
    public function update($id, Hero $hero, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Hero::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Hero introuvable'
            );
        }

        $data->setClass($hero->getClass());
        $data->setSubClass($hero->getSubClass());
        $data->setImg($hero->getImg());
        $data->setDescription($hero->getDescription());
        $data->setSkillSlotLvl($hero->getSkillSlotLvl());
        $data->setGoldCost($hero->getGoldCost());
        $data->setGemCost($hero->getGemCost());
        $data->setPrerequisite($hero->getPrerequisite());
        $data->setCritRate($hero->getCritRate());
        $data->setCritDmg($hero->getCritDmg());
        $data->setThreat($hero->getThreat());
        $data->setHp($hero->getHp());
        $data->setAtk($hero->getAtk());
        $data->setDef($hero->getDef());
        $data->setEva($hero->getEva());
        $data->setElement($hero->getElement());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/hero/delete/{id}",
     *    name = "hero_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $hero = $em->getRepository(Hero::class)->find($id);

        if (!$hero) {
            throw $this->createNotFoundException(
                'Hero introuvable'
            );
        }

        $em->remove($hero);
        $em->flush();

        return $hero;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/hero/{id}",
     *    name = "hero_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $hero = $em->getRepository(Hero::class)->find($id);

        if (!$hero) {
            throw $this->createNotFoundException(
                'Hero introuvable'
            );
        }
        return $hero;
    }

    /**
     * @Rest\Get(
     *    path = "/api/hero",
     *    name = "hero_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $hero = $this->getDoctrine()->getRepository('App:Hero')->findAll();

        return $hero;
    }
}
