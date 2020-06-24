<?php

namespace App\Controller;

use App\Entity\QuestComponent;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class QuestComponentController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/quest/component/create",
     *    name = "questComponent_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("component", converter="fos_rest.request_body")
     */
    public function create(QuestComponent $component, ConstraintViolationList $violations)
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

        $er->createManyToOne($em, $component, "component", "Component");
        $er->createManyToOne($em, $component, "quest", "Quest");
        
        $em->persist($component);
        $em->flush();

        return $this->view(
            $component,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'questComponent_id',
                ['id' => $component->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/quest/component/update/{id}",
     *    name = "questComponent_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("component", converter="fos_rest.request_body")
     */
    public function update($id, QuestComponent $component, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(QuestComponent::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Ressource introuvable'
            );
        }

        $data->setMin($component->getMin());
        $data->setMax($component->getMax());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/quest/component/delete/{id}",
     *    name = "questComponent_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $component = $em->getRepository(QuestComponent::class)->find($id);

        if (!$component) {
            throw $this->createNotFoundException(
                'Ressource introuvable'
            );
        }

        $em->remove($component);
        $em->flush();

        return $component;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/quest/component/{id}",
     *    name = "questComponent_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $component = $em->getRepository(QuestComponent::class)->find($id);

        if (!$component) {
            throw $this->createNotFoundException(
                'Ressource introuvable'
            );
        }
        return $component;
    }

    /**
     * @Rest\Get(
     *    path = "/api/quest/component",
     *    name = "questComponent_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $component = $this->getDoctrine()->getRepository('App:QuestComponent')->findAll();

        return $component;
    }
}