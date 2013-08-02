<?php

namespace Kampyeri\Ci\Entity;

class RepoNotificationEmailTest extends \PHPUnit_Framework_TestCase
{
    public function testAttributes()
    {
        $entity = new RepoNotificationEmail();
        $this->assertObjectHasAttribute('id', $entity);
        $this->assertObjectHasAttribute('repo_id', $entity);
        $this->assertObjectHasAttribute('email', $entity);
    }
}