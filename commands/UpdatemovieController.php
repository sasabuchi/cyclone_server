<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\CycloneAction;
use app\models\MovieURLForm;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UpdatemovieController extends Controller
{
    

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($limit = 100000, $page = 0)
    {
		    $offset = 0;
		    if($page > 0)
        {
          $offset = $limit * $page;
        }

        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        
        $cyclonActions = CycloneAction::find()
          ->from('dtb_cyclone_action')
          ->andFilterWhere(['like', 'del_flg', 0])
          ->limit($limit)
          ->offset($offset)
          ->all();

      try {

        foreach($cyclonActions as $action) {
          $movieURLFrom = new MovieURLForm();
          $flashURL = $movieURLFrom->getFlashURL($action->movie_url);
        	$html = file_get_contents($flashURL); 
        	
        	$hrefPosition = strpos($html, "href=\"http://content.xvideos.com/videos/");
          $imIndex = strpos($html, "href=\"http://porn.im");
          $video2Index = strpos($html, "href=\"http://videos2");
          $video3Index = strpos($html, "href=\"http://videos3");

        	if ($hrefPosition !== false || $imIndex !== false || $video2Index !== false || $video3Index !== false) {
        		/*
        		$startHtml = substr($html, $hrefPosition);
        		$endPosition = strpos($startHtml, "\"");
                $url = substr($startHtml, $endPosition);
                */
                if ($action->shown == 0) {
                	$action->shown = 1;
                	$action->save();
                	Yii::trace("id:" . $action->cyclone_action_id . " shown => 1");
                  echo "id:" . $action->cyclone_action_id . " shown => 1 \n";
                } else {
                  echo "id:" . $action->cyclone_action_id . " shown = 1 not changed\n";
                }

        	} else {
        		if ($action->shown == 1) {
                	$action->shown = 0;
                	$action->save();
                	Yii::trace("id:" . $action->cyclone_action_id . " shown => 0");
                  echo "id:" . $action->cyclone_action_id . " shown => 0 \n";
                } else {
                  echo "id:" . $action->cyclone_action_id . " shown = 0 not changed \n";
                }
        	}
        }
        $transaction->commit();

      } catch(\Exception $e) {
        $transaction->rollBack();
        throw $e;
      }
    }
}
