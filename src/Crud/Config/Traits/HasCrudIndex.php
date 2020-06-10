<?php

namespace Fjord\Crud\Config\Traits;

use Fjord\Vue\Crud\CrudTable;
use Illuminate\Database\Eloquent\Builder;

trait HasCrudIndex
{
    /**
     * Is index table sortable.
     *
     * @var boolean
     */
    public $sortable = false;

    /**
     * Index table search keys.
     *
     * @var array
     */
    public $search = ['title'];

    /**
     * Index table sort by default.
     *
     * @var string
     */
    public $sortByDefault = 'id.desc';

    /**
     * Items per page.
     *
     * @var integer
     */
    public $perPage = 10;

    /**
     * Initialize index query.
     *
     * @param Builder $query
     * @return Builder $query
     */
    public function indexQuery(Builder $query)
    {
        return $query;
    }

    /**
     * Sort by keys.
     *
     * @return array $sortBy
     */
    public function sortBy()
    {
        return [
            'id.desc' => 'New first',
            'id.asc' => 'Old first',
        ];
    }

    /**
     * Index table filter groups.
     *
     * @return void
     */
    public function filter()
    {
        return [];
    }
}
