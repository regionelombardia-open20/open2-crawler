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

use open2\crawler\frontend\classes\CrawlContainer;
use luya\helpers\FileHelper;
use yii\console\widgets\Table;

/**
 * Crawler console Command.
 *
 * ```sh
 * ./vendor/bin/luya crawler/crawl
 * ```
 *
 * Add verbositiy while crawling:
 *
 * ```sh
 * ./vendor/bin/luya crawler/crawl --verbose
 * ```
 *
 * @since 1.0.0
 */
class CrawlController extends \luya\console\Command
{
    public $verboseDebug = true;
    
    public function actionIndex($resume = false)
    {
        // sart time measuremnt
        $start = microtime(true);
       
        $container = new CrawlContainer([
            'baseUrl' => $this->module->baseUrl,
            'filterRegex' => $this->module->filterRegex,
            'verbose' => $this->verbose,
            'verboseDebug' => $this->verboseDebug,
            'doNotFollowExtensions' => $this->module->doNotFollowExtensions,
            'useH1' => $this->module->useH1,
            'resume' => $resume,
        ]);
        
        $timeElapsed = round((microtime(true) - $start) / 60, 2);
        
        $table = new Table();
        $table->setHeaders(['status', 'url', 'message']);
        $table->setScreenWidth(80);
        $table->setRows($container->getReport());
        $this->output($table->run());
        $this->outputInfo('memory usage: ' . FileHelper::humanReadableFilesize(memory_get_usage()));
        $this->outputInfo('memory peak usage: ' . FileHelper::humanReadableFilesize(memory_get_peak_usage()));
        
        return $this->outputSuccess('Crawler finished in ' . $timeElapsed . ' min.');
    }

     /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return ['verbose', 'interactive', 'verboseDebug'];
    }

}
