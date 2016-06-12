<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class MovieURLForm extends Model
{
    static $FLASH_MOVIE_URL = "http://flashservice.xvideos.com/embedframe/";
    static $PC_MOVIE_URL = "http://www.xvideos.com/video";
    static $PC_JP_MOVIE_URL = "http://jp.xvideos.com/video";

    public function checkFlashURL($flashURL)
    {
        return substr($flashURL,  0, strlen(self::$FLASH_MOVIE_URL)) === self::$FLASH_MOVIE_URL;
    }

    private function checkPcURL($pcURL)
    {
        return substr($pcURL,  0, strlen(self::$PC_MOVIE_URL)) === self::$PC_MOVIE_URL || substr($pcURL,  0, strlen(self::$PC_JP_MOVIE_URL)) === self::$PC_JP_MOVIE_URL;
    }

    private function pcURLFromFlashURL($smartURL)
    {
        $movieNo = str_replace(self::$FLASH_MOVIE_URL, "", $smartURL);
        return self::$PC_MOVIE_URL . $movieNo . "/";
    }

    private function flashURLFromPcURL($pcURL)
    {
        $movieNo = "";
        
        $movieNo = str_replace(self::$PC_MOVIE_URL, "", $pcURL);
        $movieNo = str_replace(self::$PC_JP_MOVIE_URL, "", $movieNo);

        return self::$FLASH_MOVIE_URL . $movieNo;
    }

    public function getFlashURL($url)
    {
        if ($this->checkFlashURL($url)) {
            $result = $url;
        } else if ($this->checkPcURL($url)) {
            $result = $this->flashURLFromPcURL($url);
        } else {
            $result = null;
        }
        return $result;
    }
}
