<?php

namespace Kampyeri\Ci\Entity;

class RepoTest extends \PHPUnit_Framework_TestCase
{
    public function testAttributes()
    {
        $entity = new Repo();
        $this->assertObjectHasAttribute('id', $entity);
        $this->assertObjectHasAttribute('url', $entity);
        $this->assertObjectHasAttribute('repo_type', $entity);
        $this->assertObjectHasAttribute('username', $entity);
        $this->assertObjectHasAttribute('password', $entity);
    }
}