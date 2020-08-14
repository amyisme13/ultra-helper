<?php

namespace Amyisme13\UltraHelper\Contracts;

abstract class UsersPaginationData {
    /**
     * Total rows
     *
     * @var int
     */
    public $num_rows;

    /**
     * Total pages
     *
     * @var int
     */
    public $num_pages;

    /**
     * Users count per page
     *
     * @var int
     */
    public $page_size;
}
