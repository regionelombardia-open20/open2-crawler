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

namespace open2\crawler\widgets;

use luya\base\Widget;
use open2\crawler\models\Index;
use luya\helpers\Html;
use yii\base\InvalidConfigException;
use open2\crawler\frontend\Module;
use yii\data\DataProviderInterface;

/**
 * Did you mean?
 * 
 * Returns a did you mean klickable link based on search input data.
 * 
 * ```php
 * DidYouMeanWidget::widget([
 *     'query' => $query,
 *     'language' => $language,
 *     'dataProvider' => $provider,
 * ]);
 * ```
 * 
 * @since 1.0.5
 */
class DidYouMeanWidget extends Widget
{
    /**
     * @var string The query from the search request.
     */
    public $query;

    /**
     * @var string The language determines on what index the did you mean suggestion should be made.
     */
    public $language;

    /**
     * @var mixed The route which is used for the href tag.
     */
    public $route = '/crawler/default';

    /**
     * @var array Optional arguments for the wrapper pragraph (p).
     */
    public $tagOptions = [];

    /**
     * @var array Optional arguments for the link (a) html tag.
     */
    public $linkOptions = [];

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();

        if (!$this->language || !$this->_dataProvider) {
            throw new InvalidConfigException("The query, language and dataProvider properties can not be null.");
        }
    }

    private $_dataProvider;

    /**
     * Setter method for data provider
     *
     * @param DataProviderInterface $provider
     */
    public function setDataProvider(DataProviderInterface $provider)
    {
        $this->_dataProvider = $provider;
    }

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        if (empty($this->query) || $this->_dataProvider->totalCount > 0) {
            return;
        }

        $didYouMean = Index::didYouMean($this->query, $this->language);

        if ($didYouMean) {
            $content = Html::a(Module::t("Did you mean <b>{word}</b>?", ['word' => $didYouMean]), [$this->route, 'query' => $didYouMean], $this->linkOptions);
            return Html::tag('p', $content, $this->tagOptions);
        }
    }
}