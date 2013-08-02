<?php

namespace Kampyeri\Ci\Repo;

use Kampyeri\Ci\Entity\Repo;
use Kampyeri\Ci\Exception;
use Kampyeri\Ci\Persistent\IRepoManager;

class Subversion
{
    protected $repoManager;

    /**
     * @param IRepoManager $repoManager
     */
    public function __construct(IRepoManager $repoManager)
    {
        $this->repoManager = $repoManager;
    }

    /**
     * @return IRepoManager
     */
    public function getRepoManager()
    {
        return $this->repoManager;
    }

    /**
     * @param $url
     * @param array $optional
     * @return object
     * @throws \Kampyeri\Ci\Exception
     */
    public function validateCreateParams($url, array $optional = array())
    {
        // Bağlantı geçerliliği kontrolü
        if (!filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            throw new Exception('Url is not valid!', 1, 400);
        }

        $username = isset($optional['username']) ? $optional['username'] : null;
        $password = isset($optional['password']) ? $optional['password'] : null;

        // Opsiyonel olan kullanıcı adı anahtarı gelmişse boş olma durumunu kontrol et.
        if ($username !== null && !trim($username)) {
            throw new Exception('Username is empty!', 3, 400);
        }

        // Bağlantının varlığı kontrol ediliyor.
        if ($this->getRepoManager()->checkRepoUrl($url)) {
            throw new Exception('Repository is already added.', 2, 403);
        }

        return (object)array(
            'url' => $url,
            'username' => $username,
            'password' => $password
        );
    }

    /**
     * @param $url
     * @param array $optional
     * @return Repo
     */
    public function create($url, array $optional = array())
    {
        $validParams = $this->validateCreateParams($url, $optional);

        // Bilgileri sınıfa aktar.
        $repo = new Repo();
        $repo->url = $validParams->url;
        $repo->repo_type = 'subversion';
        $repo->username = $validParams->username;
        $repo->password = $validParams->password;

        // Sınıfı kaydet.
        $this->getRepoManager()->insert($repo);

        return $repo;
    }
}
