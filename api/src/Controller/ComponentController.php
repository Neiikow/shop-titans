<?php

namespace App\Controller;

use App\Entity\Component;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class ComponentController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/component/create",
     *    name = "component_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("component", converter="fos_rest.request_body")
     */
    public function create(Component $component, ConstraintViolationList $violations)
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

        $er->createManyToOne($em, $component, 'area', 'QuestArea');

        $em->persist($component);
        $em->flush();

        return $this->view(
            $component,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'component_id',
                ['id' => $component->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/component/update/{id}",
     *    name = "component_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("component", converter="fos_rest.request_body")
     */
    public function update($id, Component $component, ConstraintViolationList $violations)
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
        $data = $em->getRepository(Component::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Composant introuvable'
            );
        }

        $er->createManyToOne($em, $component, 'area', 'QuestArea', $data);

        $data->setName($component->getName());
        $data->setImg($component->getImg());
        $data->setTier($component->getTier());
        $data->setDescription($component->getDescription());
        $data->setGoldValue($component->getGoldValue());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/component/delete/{id}",
     *    name = "component_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $component = $em->getRepository(Component::class)->find($id);

        if (!$component) {
            throw $this->createNotFoundException(
                'Composant introuvable'
            );
        }

        $em->remove($component);
        $em->flush();

        return $component;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/component/{id}",
     *    name = "component_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $component = $em->getRepository(Component::class)->find($id);

        if (!$component) {
            throw $this->createNotFoundException(
                'Composant introuvable'
            );
        }
        return $component;
    }

    /**
     * @Rest\Get(
     *    path = "/api/component",
     *    name = "component_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $component = $this->getDoctrine()->getRepository('App:Component')->findAll();

        return $component;
    }
}
