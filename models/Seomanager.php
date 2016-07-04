<?php

namespace spanjeta\seomanager\models;

use Yii;

/**
 * This is the model class for table "seomanager".
 *
 * @property integer $id
 * @property string $route
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $canonical
 * @property string $data
 * @property integer $updated
 * @property integer $created
 */
class Seomanager extends \yii\db\ActiveRecord
{

    /**
     * $position the position for the data content
     * @var integer
     */
    public $position = 1;

    /**
     * $content the content for a route
     * @var string
     */
    public $content;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
         return '{{%seomanager}}'; 
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route'], 'required'],
            [['updated', 'created', 'position'], 'integer'],
            [['created'], 'required'],
            [['route'], 'unique'],
            [['route', 'title', 'keywords', 'description', 'canonical'], 'string', 'max' => 255],
            [['data', 'content'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route' => 'Route/Url',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'canonical' => 'Canonical',
            'position' => 'Position',
            'data' => 'Data',
            'updated' => 'Updated',
            'created' => 'Created',
        ];
    }


public function getAvailableControllers()
{
    $controllerlist = [];
$name = Yii::getAlias('@app');


    if ($handle = opendir($name.'/controllers')) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                $controllerlist[] = $file;
            }
        }
        closedir($handle);
    }



    $fulllist = [];
    foreach ($controllerlist as $controller):

        $handle = fopen($name.'/controllers/' . $controller, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (preg_match('/public function action(.*?)\(/', $line, $display)):
                    if (strlen($display[1]) > 2):
                        $fulllist[substr($controller, 0, -4)] = ['title'=> strtolower($display[1]),'controller'=>substr($controller, 0, -4)];


                    endif;
                endif;
            }
        }
        fclose($handle);

    endforeach;

    return $fulllist;
}
}
