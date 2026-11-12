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

namespace open2\crawler\frontend\commands;

use Yii;
use luya\console\Command;
use open2\crawler\models\Searchdata;
use yii\console\Exception;

/**
 * Send E-Mail of search statistic for last 7 days.
 *
 * Console command use:
 *
 * ```sh
 * ./vendor/bin/luya crawler/statistic
 * ```
 *
 * @since 1.0.0
 */
class StatisticController extends Command
{
    public function actionIndex()
    {
        if (empty($this->module->statisticRecipients)) {
            throw new Exception("You have to define at least one statisticRecipients in your configuration to send the stats mail.");
        }
        
        $lastWeek = strtotime("-1 week");

        $results = Searchdata::find()->where(['>=', 'timestamp', $lastWeek])->asArray()->all();
        
        $data = [
            'noresults' => [],
            'results' => [],
        ];
        
        foreach ($results as $query) {
            if (empty($query['results'])) {
                $data['noresults'][] = $query;
            } else {
                $data['results'][] = $query;
            }
        }
        
        $html = '<h1>Search analytics from '. date("d.m.Y", $lastWeek) . ' until '.date("d.m.Y", time()).'</h1>';
        $html.= '<p>Page: ' . Yii::$app->siteTitle.'</p>';
        $html.= '<p>Number of searches: <strong>'.count($results).'</strong></p>';
        
        if (!empty($data['noresults'])) {
            $html.= '<p>Querys <b>without</b> results:</p>';
            $html.= '<table border="1" cellpadding="4" cellspacing="0"><tr><td>Query</td><td>Language</td><td>Date</td></tr>';
            foreach ($data['noresults'] as $item) {
                $html.= '<tr><td>'.$item['query'].'</td><td>'.$item['language'].'</td><td>'. date("d.m.Y", $item['timestamp']).'</td></tr>';
            }
            $html.='</table>';
        }
        
        if (!empty($data['results'])) {
            $html.= '<p>Querys <b>with</b> results:</p>';
            $html.= '<table border="1" cellpadding="4" cellspacing="0"><tr><td>Query</td><td>Results</td><td>Language</td><td>Date</td></tr>';
            foreach ($data['results'] as $item) {
                $html.= '<tr><td>'.$item['query'].'</td><td>'.$item['results'].'</td><td>'.$item['language'].'</td><td>'. date("d.m.Y", $item['timestamp']).'</td></tr>';
            }
            $html.='</table>';
        }
        
        Yii::$app->mail->compose('[' . Yii::$app->siteTitle.'] Search analytics from '. date("d.m.Y", $lastWeek) . ' until '.date("d.m.Y", time()), $html)->addresses($this->module->statisticRecipients)->send();
        
        return $this->outputSuccess('Search analytics mail sent');
    }
}
