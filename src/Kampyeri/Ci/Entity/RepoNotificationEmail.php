<?php

namespace Kampyeri\Ci\Entity;

class RepoNotificationEmail
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $repo_id;

    /**
     * @var string
     */
    public $email;
}
