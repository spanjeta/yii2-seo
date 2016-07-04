<?php


namespace spanjeta\modules\seomanager;

use spanjeta\seomanager\component\SeomanagerHelper;

class Module extends \yii\base\Module
{

   /**
     * @inheritdoc
     */
    public $controllerNamespace = 'spanjeta\modules\seomanager\controllers';


    /**
     * $cache enable caching for the seomanager
     * the routes and the associated information such as title, etc will be chached
     * @var boolean
     */
    public $cache = false;

    public $seoPage;

    public function init()
    {
        parent::init();
    }

    /**
     * @return string|null get the content from the route
     */
    public function getContent() {
        $seo = new SeomanagerHelper();
        return $seo->getContent();
    }
}
