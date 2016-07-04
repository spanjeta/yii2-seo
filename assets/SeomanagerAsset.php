<?php

namespace spanjeta\seomanager\assets;

use yii\web\AssetBundle;

/**
 * Seomanger asset bundle
 *
 * @author Shiv Charan Panjeta <shiv@toxsl.com> <shivcharan.panjeta@gmail.com>
 */
class SeomanagerAsset extends AssetBundle
{
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
