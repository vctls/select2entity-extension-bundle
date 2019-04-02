<?php

namespace Vctls\Select2EntityExtensionBundle\Util;

use Doctrine\ORM\QueryBuilder;

/**
 * Provides a method to populate Select2EntityType form fields.
 *
 * Override its properties in a child class to adapt the query to your desired entity. 
 */
class Searcher
{
    /** @var string A regular expression for splitting search terms. */
    const PATTERN_TERME = "#\s+(?:-\s+)*#";
    /** @var string A regular expression to match alphanumeric characters. */
    const PATTERN_NOT_ALPHANUM = '/^[^[:alnum:]]$/i';

    /** @var string The alias of the desired entity. */
    public $alias = 'entity';

    /** @var string The name of the method that returns the primary key of the entity. */
    public $idMethod = 'getId';

    /** @var string The name of the method that returns a string representation of the entity. */
    public $textMethod = '__toString';

    /** @var array An array of field names that will be searched for the search terms. */
    public $searchfileds = [];

    /**
     * @var array An array of joins and their aliases.
     * It has to be set in order to search fields of associated entities.
     *
     * <code>
     * $joins = [
     *     ['entity.association', 'assoc']
     * ]
     * </code>
     */
    public $joins = [];

    /**
     * Retrieve object Select2.
     *
     * @param QueryBuilder $qb
     * @param string|array $value
     * @param int $limit
     *
     * @return array
     */
    public function search(QueryBuilder $qb, $value, $limit = 20)
    {
        // Separate each term.
        $aValue = is_array($value) ? $value : explode(" ", preg_replace(self::PATTERN_TERME, " ", trim($value)));
        
        // Remove non-alphanumeric words and duplicates.
        $aTerme = [];
        foreach ($aValue as $terme) {
            if (preg_match(self::PATTERN_NOT_ALPHANUM, $terme) || in_array($terme, $aTerme)) {
                continue;
            }
            $aTerme[] = $terme;
        }

        foreach ($this->joins as $join) {
            $qb->join($join[0], $join[1]);
        }

        $index = 0;
        
        // For each search term
        // create a WHERE clause and use the term as a parameter.
        // Each term must appear in at least one field.
        foreach ($aTerme as $value) {
            ++$index;
            $parameter = '?' . $index;
            $orX = $qb->expr()->orX();
            foreach ($this->searchfileds as $field) {
                $orX->add($qb->expr()->like(
                    $field, $parameter
                ));
            }
            $qb->andWhere($orX)->setParameter($index, "%$value%");
        }
        
        $qb->setMaxResults($limit);

        $objects = $qb->getQuery()->getResult();

        $results = [];
        foreach ($objects as $object) {
            $results[] = [
                'id' => call_user_func([$object, $this->idMethod]),
                'text' => call_user_func([$object, $this->textMethod])
            ];
        }

        return ['results' => $results];
    }
}