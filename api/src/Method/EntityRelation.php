<?php
namespace App\Method;

use App\Exception\ResourceValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

Class EntityRelation extends Controller
{
    public function createOneToOne($em, $entity, $property, $relation)
    {
        $getProperty = "get".ucfirst($property);
        $setProperty = "set".ucfirst($property);

        if ($entity->$getProperty() && $entity->$getProperty()->getId()) {
            $id = $em->getRepository("App\Entity\\".$relation)->find($entity->$getProperty()->getId());
            if (!$id) {
                throw $this->createNotFoundException('Relation impossible : Ressource introuvable');
            }
            
            $query = $em->createQuery(
                'SELECT e
                FROM ' . get_class($entity) . ' e
                WHERE e.' . $property . ' = :id'
            )->setParameter('id', $id);

            if ($query->getResult()) {
                throw new ResourceValidationException('Relation impossible : Ressource déjà en relation');
            }
            return $entity->$setProperty($id);
        }
        return $entity->$setProperty(null);
    }

    public function createManyToOne($em, $entity, $property, $relation, $data=null)
    {
        $getProperty = "get".ucfirst($property);
        $setProperty = "set".ucfirst($property);

        if ($entity->$getProperty() && $entity->$getProperty()->getId()) {
            $id = $em->getRepository("App\Entity\\".$relation)->find($entity->$getProperty()->getId());
            if (!$id) {
                throw $this->createNotFoundException('Relation impossible : Ressource introuvable');
            }
            if (isset($data)) {
                return $data->$setProperty($id);
            }
            return $entity->$setProperty($id);
        }
        if (isset($data)) {
            return $data->$setProperty(null);
        }
        return $entity->$setProperty(null);
    }
}