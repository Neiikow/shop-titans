<?php

namespace App\Controller;

use App\Entity\ItemCategory;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;

class ItemCategoryController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/api/admin/item/category/create",
     *    name = "itemCategory_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("category", converter="fos_rest.request_body")
     */
    public function create(ItemCategory $category, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        return $this->view(
            $category,
            Response::HTTP_CREATED,
            ['Location' =>$this->generateUrl(
                'itemCategory_id',
                ['id' => $category->getId()])
            ]
        );
    }

    /**
     * @Rest\Post(
     *    path = "/api/admin/item/category/update/{id}",
     *    name = "itemCategory_update",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @ParamConverter("category", converter="fos_rest.request_body")
     */
    public function update($id, ItemCategory $category, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Données reçues non valides :';
            foreach ($violations as $violation) {
                $message .= sprintf(" %s : %s", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(ItemCategory::class)->find($id);        

        if (!$data) {
            throw $this->createNotFoundException(
                'Catégorie introuvable'
            );
        }

        $data->setName($category->getName());
        $data->setImg($category->getImg());
        
        $em->flush();

        return $data;
    }

    /**
     * @Rest\Delete(
     *    path = "/api/admin/item/category/delete/{id}",
     *    name = "itemCategory_delete",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(ItemCategory::class)->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'Catégorie introuvable'
            );
        }

        $em->remove($category);
        $em->flush();

        return $category;
    }
    
    /**
     * @Rest\Get(
     *    path = "/api/item/category/{id}",
     *    name = "itemCategory_id",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readId($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(ItemCategory::class)->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'Catégorie introuvable'
            );
        }
        return $category;
    }

    /**
     * @Rest\Get(
     *    path = "/api/item/category",
     *    name = "itemCategory_list",
     * )
     * @Rest\View
     */
    public function readAll()
    {
        $category = $this->getDoctrine()->getRepository('App:ItemCategory')->findAll();

        return $category;
    }
}
