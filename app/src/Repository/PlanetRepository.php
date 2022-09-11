<?php

namespace App\Repository;

use App\Entity\Planet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Planet>
 *
 * @method Planet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planet[]    findAll()
 * @method Planet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planet::class);
    }

    /**
     * @throws Exception
     */
    public function add($params): Planet|string
    {
        $planet = new Planet();
        $this->dynamicSetter($params, $planet);
        try {
            $this->_em->persist($planet);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $planet;
    }

    /**
     * @param $params
     * @param Planet $planet
     */
    private function dynamicSetter($params, Planet $planet): void
    {
        foreach ($params as $key => $param) {
            $function = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            $planet->$function($param);
        }
    }
}
