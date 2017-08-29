<?php
/**
 * Ahthor: lf
 * Email: job@feehi.com
 * Blog: http://blog.feehi.com
 * Date: 2016/10/16 17:15
 */
namespace feehi\helpers;

use yii;
use yii\helpers\FileHelper;

class FileDependencyHelper extends \yii\base\Object{

    public $rootDir = '@runtime/cache/file_dependency/';
    public $fileName;

    public function init()
    {
        parent::init();
    }

    public function createFile()
    {
        $cacheDependencyFileName = $this->getDependencyFileName();
        if( !file_exists($cacheDependencyFileName) ){
            if( !file_exists( dirname( $cacheDependencyFileName ) ) ) FileHelper::createDirectory( dirname($cacheDependencyFileName) );
            file_put_contents($cacheDependencyFileName, uniqid());
        }
        return $cacheDependencyFileName;
    }

    public function updateFile()
    {
        $cacheDependencyFileName = $this->getDependencyFileName();
        if( file_exists($cacheDependencyFileName) ){
            file_put_contents($cacheDependencyFileName, uniqid());
        }
    }

    protected function getDependencyFileName()
    {
        return yii::getAlias( $this->rootDir.$this->fileName );
    }
}