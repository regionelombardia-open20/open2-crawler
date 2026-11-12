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

namespace open2\crawler\admin\apis;

use yii\data\ActiveDataProvider;
use open2\crawler\models\Searchdata;


/**
 * Search API.
 *
 * @since 1.0.0
 */
class SearchdataController extends \luya\admin\ngrest\base\Api
{
    /**
     * @var string $modelClass The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = '\open2\crawler\models\Searchdata';

    /**
     * Get latest search data.
     *
     * @return ActiveDataProvider
     * @since 1.0.6
     */
    public function actionLatest()
    {
        return new ActiveDataProvider([
            'query' => Searchdata::find()->where(['=', 'results', 0]),
            'pagination' => ['defaultPageSize' => 10],
            'sort'=> ['defaultOrder' => ['timestamp' => SORT_DESC]]
        ]);
    }
}
