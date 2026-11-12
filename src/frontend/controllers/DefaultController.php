<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open2\crawler
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

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
