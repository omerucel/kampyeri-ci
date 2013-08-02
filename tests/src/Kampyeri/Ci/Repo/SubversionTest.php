<?php

namespace Kampyeri\Ci\Repo;

use Kampyeri\Ci\Entity\Repo;
use Kampyeri\Ci\Entity\RepoNotificationEmail;

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

    public function testSetNotificationEmails()
    {
        $repoManager = $this->getMock('Kampyeri\Ci\Persistent\IRepoManager');
        $repoManager->expects($this->once())
            ->method('setNotificationEmails')
            ->withAnyParameters()
            ->will(
                $this->returnValue(
                    array(
                        new RepoNotificationEmail(),
                        new RepoNotificationEmail()
                    )
                )
            );
        $subversion = new Subversion($repoManager);
        $repo = new Repo();

        $notificationEmails = array(
            'email1@email.com',
            'email2@email.com',
            'email2@email.com'
        );
        $entities = $subversion->setNotificationEmails($repo, $notificationEmails);
        $this->assertCount(2, $entities);
        $this->assertInstanceOf('Kampyeri\Ci\Entity\RepoNotificationEmail', $entities[0]);
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

    public function testNotificationEmailNotValid()
    {
        $repoManager = $this->getMock('Kampyeri\Ci\Persistent\IRepoManager');
        $subversion = new Subversion($repoManager);
        $repo = new Repo();

        $notificationEmails = array(
            'email1@email.com',
            'email2'
        );

        $this->setExpectedException('Kampyeri\Ci\Exception', 'Notification email is not valid!', 4);
        $subversion->setNotificationEmails($repo, $notificationEmails);
    }
}
