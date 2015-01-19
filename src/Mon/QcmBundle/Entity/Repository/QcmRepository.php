<?php

namespace Mon\QcmBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class QcmRepository extends EntityRepository
{
    /**
     * @param bool $withQuestions
     * @param bool $withPropositions
     * @return mixed
     */
    public function loadAll($withQuestions = false, $withPropositions = false)
    {
        return $this->prepareLoadQuery($withQuestions, $withPropositions)->getQuery()->execute();
    }

    /**
     * @param $id
     * @param bool $withQuestions
     * @param bool $withPropositions
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadOne($id, $withQuestions = false, $withPropositions = false)
    {
        $qb = $this->prepareLoadQuery($withQuestions, $withPropositions);
        $qb->andWhere($qb->expr()->eq('q.id', ':id'))->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param bool $withQuestions
     * @param bool $withPropositions
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function prepareLoadQuery($withQuestions = false, $withPropositions = false) {
        $qb = $this->createQueryBuilder('q');
        $qb->select('q');

        if ($withQuestions) {
            $qb->leftJoin('q.questions', 'qq')->addSelect('qq');

            if ($withPropositions) {
                $qb->leftJoin('qq.propositions', 'qp')->addSelect('qp');
            }
        }
        else {
            if ($withPropositions) {
                throw new \InvalidArgumentException('Unable to load propositions without loading questions');
            }
        }

        return $qb;
    }
} 