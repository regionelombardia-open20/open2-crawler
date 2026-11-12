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

use luya\web\Controller;
use open2\crawler\models\Click;
use open2\crawler\models\Index;

/**
 * Click Index Controller.
 *
 * Add a click for a given url and redirect to its origin target.
 *
 * @since 1.0.0
 */
class ClickController extends Controller
{
    /**
     * Generate a click for a given search.
     *
     * @param integer $searchId
     * @param integer $indexId
     * @param integer $position
     * @throws \Exception
     * @return \yii\web\Response
     */
    public function actionIndex($searchId, $indexId, $position)
    {
        $model = new Click();
        $model->attributes = [
            'searchdata_id' => $searchId,
            'index_id' => $indexId,
            'timestamp' => time(),
            'position' => $position,
        ];
        // save whether valid or not, as user must be redirected.
        $model->save(false);
        
        $index = Index::findOne($indexId);
        
        if ($index) {
            return $this->redirect($index->url);
        }
        
        throw new \Exception("Unable to find index.");
    }
}
