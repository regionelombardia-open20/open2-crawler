<?php

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
