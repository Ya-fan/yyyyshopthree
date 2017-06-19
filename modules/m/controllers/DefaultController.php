<?php
namespace app\modules\m\controllers;

use app\modules\m\controllers\common\BaseMController;

use app\models\BrandImages;
use app\models\BrandSetting;


use yii\web\Controller;

/**
 * Default controller for the `m` module
 */
class DefaultController extends BaseMController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = 'main';
    public function actionIndex()
    {
    	$brand_info = BrandSetting::find()->one();

        $imgae_list = BrandImages::find()->orderBy( ['id'=>SORT_DESC] )->all();

        return $this->render('index',[
                'brand_info'=>$brand_info,
                'imgae_list'=>$imgae_list,
            ]);
    }
}
