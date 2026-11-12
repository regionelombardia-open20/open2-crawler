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

namespace open2\crawler\admin;

use luya\admin\components\AdminMenuBuilder;

/**
 * LUYA Crawler Admin Module.
 *
 * @since 1.0.0
 */
final class Module extends \luya\admin\base\Module
{
    /**
     * @inheritdoc
     */
    public $apis = [
        'api-crawler-builderindex' => 'open2\crawler\admin\apis\BuilderindexController',
        'api-crawler-index' => 'open2\crawler\admin\apis\IndexController',
        'api-crawler-searchdata' => 'open2\crawler\admin\apis\SearchdataController',
    ];
    
    public $dashboardObjects = [
        [
            'class' => 'luya\admin\dashboard\ListDashboardObject',
            'template' => '<li class="list-group-item" ng-repeat="item in data">{{item.query}} <small>({{item.language}})</small><span class="badge badge-info float-right">{{item.timestamp * 1000 | date:\'short\'}}</span></li>',
            'dataApiUrl' => 'admin/api-crawler-searchdata/latest',
            'title' => ['crawleradmin', 'dashboard_title'],
        ],
    ];

    /**
     * @inheritdoc
     */
    public function getMenu()
    {
        return (new AdminMenuBuilder($this))->node('crawler', 'find_in_page')
        ->group('crawler_index')
            ->itemApi('crawler_index', 'crawleradmin/index/index', 'list', 'api-crawler-index')
        ->group('crawler_analytics')
            ->itemApi('crawler_analytics_queries', 'crawleradmin/searchdata/index', 'label', 'api-crawler-searchdata');
    }
    
    /**
     * @inheritdoc
     */
    public static function onLoad()
    {
        self::registerTranslation('crawleradmin', static::staticBasePath() . '/messages', [
            'crawleradmin' => 'crawleradmin.php',
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function t($message, array $params = [])
    {
        return parent::baseT('crawleradmin', $message, $params);
    }
}
