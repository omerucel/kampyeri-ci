<?php

namespace Kampyeri\Ci\Repo;

class SubversionTest extends \PHPUnit_Framework_TestCase
{
    public function testValidateCreateParams()
    {
        $repoManager = $this->getMock('Kampyeri\Ci\Persistent\IRepoManager');
        $subversion = new Subversion($repoManager);

        $url = 'http://svn.project.com/';
        $optional = array(
            'username' => 'user',
            'password' => 'pass'
        );
        $validParams = $subversion->validateCreateParams($url, $optional);
        $this->assertObjectHasAttribute('url', $validParams);
        $this->assertObjectHasAttribute('username', $validParams);
        $this->assertObjectHasAttribute('password', $validParams);
        $this->assertEquals($url, $validParams->url);
        $this->assertEquals('user', $validParams->username);
        $this->assertEquals('pass', $validParams->password);
    }

    public function testCreate()
    {
        $repoManager = $this->getMock('Kampyeri\Ci\Persistent\IRepoManager');
        $subversion = new Subversion($repoManager);

        $url = 'http://svn.project.com/';
        $entity = $subversion->create($url);
        $this->assertInstanceOf('Kampyeri\Ci\Entity\Repo', $entity);
    }

    public function testCreateWithUsernameAndPassword()
    {
        $repoManager = $this->getMock('Kampyeri\Ci\Persistent\IRepoManager');
        $subversion = new Subversion($repoManager);

        $url = 'http://svn.project.com/';
        $optional = array(
            'username' => 'user',
            'password' => 'pass'
        );
        $entity = $subversion->create($url, $optional);
        $this->assertInstanceOf('Kampyeri\Ci\Entity\Repo', $entity);
    }

    public function testInvalidUrl()
    {
        $repoManager = $this->getMock('Kampyeri\Ci\Persistent\IRepoManager');
        $subversion = new Subversion($repoManager);

        $this->setExpectedException('Kampyeri\Ci\Exception', 'Url is not valid!', 1);
        $url = 'http://svn.project.com';
        $subversion->create($url);
    }

    public function testUsernameIsEmpty()
    {
        $repoManager = $this->getMock('Kampyeri\Ci\Persistent\IRepoManager');
        $subversion = new Subversion($repoManager);

        $this->setExpectedException('Kampyeri\Ci\Exception', 'Username is empty!', 3);
        $url = 'http://svn.project.com/';
        $optional = array(
            'username' => ''
        );
        $subversion->create($url, $optional);
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
