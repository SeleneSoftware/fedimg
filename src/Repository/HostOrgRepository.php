<?php

namespace App\Repository;

use App\Entity\HostOrg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @extends ServiceEntityRepository<HostOrg>
 *
 * @method HostOrg|null find($id, $lockMode = null, $lockVersion = null)
 * @method HostOrg|null findOneBy(array $criteria, array $orderBy = null)
 * @method HostOrg[]    findAll()
 * @method HostOrg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HostOrgRepository extends ServiceEntityRepository
{
    protected $client;

    public function __construct(ManagerRegistry $registry, HttpClientInterface $client)
    {
        $this->client = $client;
        parent::__construct($registry, HostOrg::class);
    }

    public function save(HostOrg $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HostOrg $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HostOrg[] Returns an array of HostOrg objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findOneLocalBySiteNick($value): ?HostOrg
    {
        return $this->createQueryBuilder('h')
           ->andWhere('h.nick = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
        ;
    }

    // So I'm gunna make this search available hosts in the case we don't know the sitecode
    public function findOneBySiteNick($value): ?HostOrg
    {
        $host = $this->findOneLocalBySiteNick($value);
        if (is_null($host)) {
            $hosts = $this->findAll();
            foreach ($hosts as $h) {
                $response = $this->client->request(
                    'GET',
                    'https://'.$host->getUrl().'/api/hosts'
                );
                if (200 === $response->getStatusCode()) {
                    $content = $response->toArray();
                    foreach ($content as $c) {
                        if ($value === $c['nick']) {
                            $host = new HostOrg();
                            $host->setName($c['name'])
                                    ->setNick($c['nick'])
                                    ->setUrl($c['url'])
                            ;
                            $this->save($host, true);
                        }
                    }
                }
            }
        }

        if (is_null($host)) {
            throw new NotFoundHttpException('User Not Found At @'.$value, null);
        }

        return $host;
    }
}
