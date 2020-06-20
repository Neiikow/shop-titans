<?php

namespace App\Controller;

use App\Entity\Resource;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class ResourceController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/resource/create",
     *    name = "resource_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("resource", converter="fos_rest.request_body")
     */
    public function create(Resource $resource, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($resource);
        $em->flush();

        return $this->view(
            $resource,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'resource_id',
                ['id' => $resource->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/resource/update/{id}",
     *    name = "resource_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("resource", converter="fos_rest.request_body")
     */
    public function update($id, Resource $resource, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Resource::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Ressource introuvable'
            );
        }

        $data->setName($resource->getName());
        $data->setImg($resource->getImg());
        $data->setTier($resource->getTier());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/resource/delete/{id}",
     *    name = "resource_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $resource = $em->getRepository(Resource::class)->find($id);

        if (!$resource) {
            throw $this->createNotFoundException(
                'Ressource introuvable'
            );
        }

        $em->remove($resource);
        $em->flush();

        return $resource;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/resource/{id}",
     *    name = "resource_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $resource = $em->getRepository(Resource::class)->find($id);

        if (!$resource) {
            throw $this->createNotFoundException(
                'Ressource introuvable'
            );
        }
        return $resource;
    }

    /**
     * @Rest\Get(
     *    path = "/api/resource",
     *    name = "resource_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $resource = $this->getDoctrine()->getRepository('App:Resource')->findAll();

        return $resource;
    }
}
