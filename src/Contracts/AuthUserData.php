<?php

namespace Amyisme13\UltraHelper\Contracts;

abstract class AuthUserData {
    /**
     * The moodle user id
     *
     * @var int
     */
    public $id;

    /**
     * The moodle username
     *
     * @var string
     */
    public $username;

    /**
     * User's personal email
     *
     * @var string
     */
    public $email;

    /**
     * User's full name
     *
     * @var string
     */
    public $name;
}
