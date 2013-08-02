<?php

namespace Kampyeri\Ci\Entity;

class Repo
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $repo_type;

    /**
     * @var string
     */
    public $username = null;

    /**
     * @var string
     */
    public $password = null;
}
