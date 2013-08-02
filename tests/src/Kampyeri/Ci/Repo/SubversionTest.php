<?php

namespace Kampyeri\Ci\Repo;

class SubversionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $repoManager = $this->getMock('Kampyeri\Ci\Persistent\IRepoManager');
        $subversion = new Subversion($repoManager);

        $url = 'http://svn.project.com/';
        $entity = $subversion->create($url);
        $this->assertInstanceOf('Kampyeri\Ci\Entity\Repo', $entity);
    }

    public function testInvalidUrlPath()
    {
        $repoManager = $this->getMock('Kampyeri\Ci\Persistent\IRepoManager');
        $subversion = new Subversion($repoManager);

        $this->setExpectedException('Kampyeri\Ci\Exception', 'Url is not valid!', 1);
        $url = 'http://svn.project.com';
        $subversion->create($url);
    }

    public function testRepoAlreadyAdded()
    {
        $repoManager = $this->getMock('Kampyeri\Ci\Persistent\IRepoManager');
        $repoManager->expects($this->once())
            ->method('checkRepoUrl')
            ->withAnyParameters()
            ->will($this->returnValue(true));

        $subversion = new Subversion($repoManager);

        $this->setExpectedException('Kampyeri\Ci\Exception', 'Repository is already added.', 2);
        $url = 'http://svn.project.com/';
        $subversion->create($url);
    }
}
