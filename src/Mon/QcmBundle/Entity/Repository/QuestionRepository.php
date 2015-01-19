<?php

namespace Mon\QcmBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * QuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionRepository extends EntityRepository
{
    public function findNextQuestionWithPropositions($qcmId, $previousPosition)
    {
        $qb = $this->createQueryBuilder('q');

        $qb
            ->leftJoin('q.propositions', 'p')
            ->select('q', 'p');

        $qb
            ->where($qb->expr()->andX(
                $qb->expr()->eq('q.qcm', ':qcm'),
                $qb->expr()->gt('q.position', ':previousPosition')
            ))
            ->orderBy('q.position', 'ASC')
            ->setMaxResults(1);

        $qb->setParameters([
            'qcm' => $qcmId,
            'previousPosition' => $previousPosition
        ]);

        return $qb->getQuery()->getOneOrNullResult();
    }

}