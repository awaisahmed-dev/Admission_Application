<?php
namespace app\components;

class Serializer extends \yii\rest\Serializer
{
     /**
     * {@inheritdoc}
     */
	 
	public $primaryAction;
    protected function serializeDataProvider($dataProvider)
    {
        $output = parent::serializeDataProvider($dataProvider);
		
        if (!is_array($output)) return $output;
		
		$output ['primaryAction'] = $this->primaryAction;
		
		return $output;
		
        /*return [
            'success' => true,
			'primaryAction' => $this->primaryAction,
            'results' =>  $output
        ] ;
		*/
    }
}