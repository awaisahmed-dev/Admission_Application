<?php

namespace frontend\modules\api\v1\resources;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Articleapi extends \common\models\Article implements Linkable
{
    public function fields()
    {
        //return ['id', 'slug', 'category_id', 'title', 'body', 'published_at'];
		
		return [
				 'objectId' => 'id', 'title', 'created' => function($model) {return	\Yii::$app->formatter->asDate($model->created_at, 'php:Y-m-d');},
				 'description'=> 'body', 'status', 'link'=> function($model){return Url::to(['article/view', 'id' => $model->id], true);},
				 'actions'=> function($model){return [[
											  "type"=> "IFRAME",
											  "width"=> 890,
											  "height"=> 748,
											  "uri"=> "https://example.com/edit-iframe-contents",
											  "label"=> "Resend Emails",
											  "associatedObjectProperties"=> []
											]];}	
		];
    }

    /*public function extraFields()
    {
        return ['category'];
    }*/

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['article/view', 'id' => $this->id], true)
        ];
    }
}
