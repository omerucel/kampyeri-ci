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
     * @return Repo
     * @throws \Kampyeri\Ci\Exception
     */
    public function create($url)
    {
        // Bağlantı geçerliliği kontrolü
        if (!filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            throw new Exception('Url is not valid!', 1, 400);
        }

        // Bağlantının varlığı kontrol ediliyor.
        if ($this->getRepoManager()->checkRepoUrl($url)) {
            throw new Exception('Repository is already added.', 2, 403);
        }

        // Bilgileri sınıfa aktar.
        $repo = new Repo();
        $repo->url = $url;
        $repo->repo_type = 'subversion';

        // Sınıfı kaydet.
        $this->getRepoManager()->insert($repo);

        return $repo;
    }
}
