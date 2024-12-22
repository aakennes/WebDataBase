<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminLteAsset extends AssetBundle
{
    public $basePath = '@webroot'; // 指向 web 目录
    public $baseUrl = '@web/adminlte'; // 指向 adminlte 目录
    public $css = [
        'css/adminlte.css', // AdminLTE 核心样式
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
