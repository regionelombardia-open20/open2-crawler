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

namespace crawlerests;

use luya\testsuite\cases\WebApplicationTestCase;
use luya\testsuite\fixtures\NgRestModelFixture;
use open2\crawler\models\Searchdata;
use crawlerests\data\fixtures\IndexFixture;

/**
 * Crawler TestCase
 */
class CrawlerTestCase extends WebApplicationTestCase
{
    public function getConfigArray()
    {
        return [
           'id' => 'mytestapp',
           'basePath' => dirname(__DIR__),
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'sqlite::memory:',
                    'charset' => 'utf8',
                ],
                'request' => [
                    'forceWebRequest' => true,
                ],
            ],
            'modules' => [
                'crawleradmin' => 'open2\crawler\admin\Module',
            ]
        ];
    }

    public function afterSetup()
    {
        parent::afterSetup();

        $searchData = new NgRestModelFixture([
            'modelClass' => Searchdata::class,
            'fixtureData' => [
                'model1' => [
                    'id' => 2,
                    'query' => 'john doe',
                    'results' => 1,
                    'language' => 'en',
                    'timestamp' => time(),
                ]
            ]
        ]);

        $indexFixture = new IndexFixture();
    }
}
