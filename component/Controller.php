<?php
/**
 * Created by PhpStorm.
 * User: info
 * Date: 09.12.2015
 * Time: 23:46
  * @author Shiv Charan Panjeta <shiv@toxsl.com> <shivcharan.panjeta@gmail.com>
 */

namespace spanjeta\seomanager\component;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $seoHelper = new SeomanagerHelper();
        $seoHelper->run();

        return parent::beforeAction($action);
    }
}
