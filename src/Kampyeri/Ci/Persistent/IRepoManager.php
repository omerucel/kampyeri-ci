<?php

namespace Kampyeri\Ci\Persistent;

use Kampyeri\Ci\Entity\Repo;

/**
 * Class IRepoManager
 * @package Kampyeri\Ci\Persistent
 */
interface IRepoManager
{
    /**
     * Gönderilen repo bilgilerini veritabanına kaydeder. İşlem başarılı ise Repo sınıfının id parametresini günceller.
     *
     * @param Repo $repo Bilgileri içeren veri sınıfı.
     * @return void
     */
    public function insert(Repo $repo);

    /**
     * Bağlantı bilgisini veritabanında kontrol eder ve geriye sonucu döner.
     *
     * @param $url string Kontrol edilecek bağlantı bilgisi.
     * @return bool
     */
    public function checkRepoUrl($url);

    /**
     * Gönderilen e-posta adreslerini repo ile ilişkilendirir. İşlem içerisinde, daha önceki ilişkili e-posta adresleri
     * silindikten sonra yeni e-posta adresleri tanıtılır.
     *
     * @param Repo $repo Repo bilgilerini içeren sınıf.
     * @param array $notificationEmails E-posta adreslerini içeren dizi.
     * @return array Sonuç olarak eklenen RepoNotificationEmail objeleri dönülür.
     */
    public function setNotificationEmails(Repo $repo, array $notificationEmails);
}
