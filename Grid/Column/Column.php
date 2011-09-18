<?php

/*
 * This file is part of the DataGridBundle.
 *
 * (c) Stanislav Turza <sorien@mail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sorien\DataGridBundle\Grid\Column;

class Column
{
    private $id;
    private $title;
    private $sortable;
    private $isSorted;
    private $filterable;
    private $visible;
    private $callback;
    private $order;
    private $size;
    private $orderUrl;
    private $visibleForSource;
    private $primary;
    private $params;

    protected $data;

    const DATA_CONJUNCTION = 0;
    const DATA_DISJUNCTION = 1;

    const OPERATOR_EQ   = 'eq';
    const OPERATOR_NEQ  = 'neq';
    const OPERATOR_LT   = 'lt';
    const OPERATOR_LTE  = 'lte';
    const OPERATOR_GT   = 'gt';
    const OPERATOR_GTE  = 'gte';
    const OPERATOR_REGEXP = 'req';

    /**
     * Default Column constructor
     *
     * @param array $params
     * @return \Sorien\DataGridBundle\Grid\Column\Column
     */
    public function __construct($params = null)
    {
        $this->__initialize((array) $params);
        $this->isSorted = false;
        $this->data = null;
        $this->order = '';
    }

    public function __initialize(array $params)
    {
        $this->params = $params;

        //var_dump('i:'.@$params['primary'].$this->getParam('primary', false));

        $this->id = $this->getParam('id', null);
        $this->title = $this->getParam('title', '');
        $this->sortable = $this->getParam('sortable', true);
        $this->visible = $this->getParam('visible', true);
        $this->size = $this->getParam('size', -1);
        $this->filterable = $this->getParam('filterable', true);
        $this->visibleForSource = $this->getParam('source', true);
        $this->primary = $this->getParam('primary', false);
    }

    public function __types()
    {
        return array();
    }

    protected function getParam($id, $default)
    {
        return isset($this->params[$id]) ? $this->params[$id] : $default;
    }


    /**
     * Draw filter
     *
     * @param string $gridHash
     * @return string
     */
    public function renderFilter($gridHash)
    {
        return '';
    }

    /**
     * Draw cell
     *
     * @param string $value
     * @param Row $row
     * @param $router
     * @return string
     */
    public function renderCell($value, $row, $router)
    {
        if (is_callable($this->callback))
        {
            return call_user_func($this->callback, $value, $row, $router);
        }
        else
        {
            return $value;
        }
    }

    /**
     * Set column callback
     *
     * @param  $callback
     * @return \Sorien\DataGridBundle\Grid\Column\Column
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * Set column identifier
     *
     * @param $id
     * @return \Sorien\DataGridBundle\Grid\Column\Column
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * get column identifier
     *
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set column title
     *
     * @param string $title
     * @return \Sorien\DataGridBundle\Grid\Column\Column
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get column title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Show column
     *
     * @return \Sorien\DataGridBundle\Grid\Column\Column
     */
    public function show()
    {
        $this->visible = true;

        return $this;
    }

    /**
     * Hide column
     *
     * @return \Sorien\DataGridBundle\Grid\Column\Column
     */
    public function hide()
    {
        $this->visible = false;

        return $this;
    }

    /**
     * Column is visible
     *
     * @return bool return true when column is visible
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * Column is sorted
     *
     * @return bool return true when column is sorted
     */
    public function isSorted()
    {
        return $this->isSorted;
    }

    /**
     * Column is filtered
     *
     * @return bool return true when column is filtred
     */
    public function isFiltered()
    {
        return $this->data != null;
    }

    /**
     * column ability to filter
     *
     * @return bool return true when column can be filtred
     */
    public function isFilterable()
    {
        return $this->filterable;
    }

    /**
     * column ability to sort
     *
     * @return bool return true when column can be sorted
     */
    public function isSortable()
    {
        return $this->sortable;
    }

    /**
     * set column order
     *
     * @param string $order asc|desc
     * @return \Sorien\DataGridBundle\Grid\Column\Column
     */
    public function setOrder($order)
    {
        $this->order = $order;
        $this->isSorted = true;

        return $this;
    }

    /**
     * get column order
     *
     * @return string asc|desc
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * get data filter connection (how column filters are connected with column data)
     *
     * @return bool column::DATA_CONJUNCTION | column::DATA_DISJUNCTION
     */
    public function getFiltersConnection()
    {
        return self::DATA_CONJUNCTION;
    }

    /**
     * get column data filters
     * todo: maybe change to own class not array
     *
     * @return \Sorien\DataGridBundle\Grid\Filter[]
     */
    public function getFilters()
    {
        return array();
    }

    /**
     * set column width
     *
     * @param int $size in pixels
     * @return \Sorien\DataGridBundle\Grid\Column\Column
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * get column width
     *
     * @return int column width in pixels
     */
    public function getSize()
    {
        return $this->size;
    }


    public function setOrderUrl($url)
    {
        $this->orderUrl = $url;

        return $this;
    }

    public function getOrderUrl()
    {
        return $this->orderUrl;
    }

    /**
     * set filter data from session | request
     *
     * @param  $data
     * @return \Sorien\DataGridBundle\Grid\Column\Column
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * get filter data from session | request
     *
     * @return array data
     */
    public function getData()
    {
        return $this->data;
    }

    public function setIsVisibleForSource($value)
    {
        $this->visibleForSource = $value;
        
        return $this;
    }

    public function isVisibleForSource()
    {
        return $this->visibleForSource;
    }

    public function isPrimary()
    {
        return $this->primary;
    }
}