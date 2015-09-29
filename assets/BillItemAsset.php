<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class BillItemAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/gridSelection.css'
    ];
    public $js = [
        'js/gridSelection.js',
        'js/billItem.js'
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}
