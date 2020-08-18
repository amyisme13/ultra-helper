<?php

namespace Amyisme13\UltraHelper\Contracts;

abstract class PointResponseData {
    /**
     * Whether the request is successful or not
     *
     * @var bool
     */
    public $st;

    /**
     * Message
     *
     * @var string
     */
    public $msg;
}
