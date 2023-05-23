<?php

namespace open2\crawler\frontend\controllers;

use Yii;
use open2\crawler\models\Index;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use open2\crawler\models\Searchdata;
use yii\data\ArrayDataProvider;

/**
 * Crawler Index Controller.
 *
 * Returns an {{\yii\data\ActiveDataProvider}} within $provider.
 *
 * @since 1.0.0
 */
class DefaultController extends \luya\web\Controller
{
    /**
     * Get search overview.
     *
     * The index action will return an active data provider object inside the $provider variable:
     *
     * ```php
     * foreach ($provider->models as $item) {
     *     var_dump($item);
     * }
     * ```
     *
     * @return string
     */
    public function actionIndex($query = null, $page = null, $group = null)
    { 
        $language = Yii::$app->composition->getKey('langShortCode');
        
        if (empty($query)) {
            $provider = new ArrayDataProvider([
                'allModels' => [],
            ]);
        } else {
            $activeQuery = Index::activeQuerySearch($query, $language);
            
            if (!empty($group)) {
                $activeQuery->andWhere(['group' => $group]);
            }
            
            $provider = new ActiveDataProvider([
                'query' => $activeQuery,
                'pagination' => [
                    'defaultPageSize' => $this->module->searchResultPageSize,
                    'route' => '/crawler/default',
                    'params' => ['query' => $query, 'page' => $page]
                ],
                'sort' => false,
            ]);
            
            $searchData = new Searchdata();
            $searchData->detachBehavior('LogBehavior');
            
            $searchData->attributes = [
                'query' => $query,
                'results' => $provider->totalCount,
                'timestamp' => time(),
                'language' => $language,
            ];
            $searchData->save();
        }
     
        return $this->render('index', [
            'query' => Html::encode($query),
            'provider' => $provider,
            'language' => $language,
        ]);
    }
}
