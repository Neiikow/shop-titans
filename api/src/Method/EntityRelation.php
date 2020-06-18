<?php
namespace App\Method;

use App\Exception\ResourceValidationException;

Class EntityRelation
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
}