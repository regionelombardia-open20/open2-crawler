<?php

namespace crawlerests\widgets;

use crawlerests\CrawlerTestCase;
use open2\crawler\widgets\DidYouMeanWidget;
use yii\data\ArrayDataProvider;
use luya\testsuite\fixtures\ActiveRecordFixture;
use open2\crawler\models\Searchdata;


class DidYouMeanWidgetTest extends CrawlerTestCase
{
    public function testRunNoIndex()
    {
        $provider = new ArrayDataProvider([
            'allModels' => [
                ['bar' => 'foo']
            ],
        ]);

        $widget = DidYouMeanWidget::widget([
            'dataProvider' => $provider,
            'query' => 'jon doe',
            'language' => 'en',
        ]);

        $this->assertSame('', $widget);
    }

    public function testRunSuggestion()
    {
        $provider = new ArrayDataProvider([
            'allModels' => [],
        ]);

        $widget = DidYouMeanWidget::widget([
            'dataProvider' => $provider,
            'query' => 'jon doe',
            'language' => 'en',
        ]);

        $this->assertContains('Did you mean <b>john doe</b>', $widget);
    }
}