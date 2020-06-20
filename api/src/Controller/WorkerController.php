<?php

namespace App\Controller;

use App\Entity\Worker;
use App\Method\EntityRelation;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class WorkerController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/worker/create",
     *    name = "worker_create"
     * )
     * @Rest\View(StatusCode = 201, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("worker", converter="fos_rest.request_body")
     */
    public function create(Worker $worker, ConstraintViolationList $violations)
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

        $er->createOneToOne($em, $worker, "artisan", "Character");
        $er->createOneToOne($em, $worker, "pack", "Pack");
        
        $em->persist($worker);
        $em->flush();

        return $this->view(
            $worker,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'worker_id',
                ['id' => $worker->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/worker/update/{id}",
     *    name = "worker_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     * @ParamConverter("worker", converter="fos_rest.request_body")
     */
    public function update($id, Worker $worker, ConstraintViolationList $violations)
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
        $data = $em->getRepository(Worker::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Artisan introuvable'
            );
        }

        $er->createOneToOne($em, $worker, "artisan", "Character", $data);
        $er->createOneToOne($em, $worker, "pack", "Pack", $data);

        $data->setDescription($worker->getDescription());
        $data->setJob($worker->getJob());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/worker/delete/{id}",
     *    name = "worker_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $worker = $em->getRepository(Worker::class)->find($id);

        if (!$worker) {
            throw $this->createNotFoundException(
                'Artisan introuvable'
            );
        }

        $em->remove($worker);
        $em->flush();

        return $worker;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/worker/{id}",
     *    name = "worker_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $worker = $em->getRepository(Worker::class)->find($id);

        if (!$worker) {
            throw $this->createNotFoundException(
                'Artisan introuvable'
            );
        }
        return $worker;
    }

    /**
     * @Rest\Get(
     *    path = "/api/worker",
     *    name = "worker_list",
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function readAll()
    {
        $worker = $this->getDoctrine()->getRepository('App:Worker')->findAll();

        return $worker;
    }
}