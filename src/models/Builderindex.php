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

namespace open2\crawler\models;

use open2\crawler\admin\Module;
use luya\helpers\StringHelper;
use luya\admin\ngrest\base\NgRestModel;
use yii\helpers\ArrayHelper;

/**
 * Temporary Builder Index Model.
 *
 * The Builder Index is used while the crawl process. After a success crawl for the given website, the whole BuilderIndex
 * will be synced into the {{open2\crawler\models\Index}} model.
 *
 * @property int $id
 * @property string $url
 * @property string $title
 * @property string $content
 * @property string $description
 * @property string $language_info
 * @property string $url_found_on_page
 * @property string $group
 * @property int $last_indexed
 * @property int $crawled
 * @property int $status_code
 * @property string $content_hash
 * @property int $is_dublication
 *
 * @since 1.0.0
 */
class Builderindex extends NgRestModel
{
    public $processed;

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'preparePageVariables']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'preparePageVariables']);
    }

    /**
     * Prepare the page variables like contant hash and if its dulication by content.
     */
    public function preparePageVariables()
    {
        $this->content_hash   = md5($this->content);
        $this->is_dublication = self::find()->where(['content_hash' => $this->content_hash])->andWhere(['!=', 'url', $this->url])->exists();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
                [['processed'], 'integer']
        ]);
    }

    public static function tableName()
    {
        return 'crawler_builder_index';
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['url', 'content', 'title', 'language_info', 'url_found_on_page', 'group', 'processed'],
            'restupdate' => ['url', 'content', 'title', 'language_info', 'url_found_on_page', 'group', 'processed'],
            'default' => ['url', 'content', 'title', 'language_info', 'content_hash', 'is_dublication', 'url_found_on_page',
                'group', 'description', 'processed'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'url' => Module::t('builderindex_url'),
            'title' => Module::t('builderindex_title'),
            'language_info' => Module::t('builderindex_language_info'),
            'content' => Module::t('builderindex_content'),
            'url_found_on_page' => Module::t('builderindex_url_found'),
        ];
    }
    /* ngrest model properties */

    public function genericSearchFields()
    {
        return ['url', 'content', 'title', 'language_info'];
    }

    public static function ngRestApiEndpoint()
    {
        return 'api-crawler-builderindex';
    }

    public function ngRestAttributeTypes()
    {
        return [
            'url' => 'Password',
            'title' => 'text',
            'language_info' => 'text',
            'url_found_on_page' => 'text',
            'content' => 'textarea',
        ];
    }

    public function ngRestConfig($config)
    {
        $this->ngRestConfigDefine($config, 'list', ['url', 'title', 'language_info', 'url_found_on_page']);
        $this->ngRestConfigDefine($config, ['create', 'update'],
            ['url', 'title', 'language_info', 'url_found_on_page', 'content']);

        return $config;
    }
    /* custom functions */

    /**
     * Whether an url is inexed or not (false = not in database or not yet crawler).
     *
     * @param string $url
     * @return boolean
     */
    public static function isIndexed($url)
    {
        $url = \open2\crawler\frontend\classes\CrawlContainer::cleanUrl($url);
        return self::find()->where(['url' => $url])->select(['crawled'])->scalar();
    }

    /**
     * Find a crawler index entry based on the url.
     * 
     * @param string $url
     * @return \open2\crawler\models\Builderindex|boolean
     */
    public static function findUrl($url)
    {
        $url = \open2\crawler\frontend\classes\CrawlContainer::cleanUrl($url);
        return self::find()->where(['url' => $url])->limit(1)->one();
    }

    /**
     * Add a given page to the index with status: uncrawled.
     *
     * If there url exists already in the index, false is returned.
     *
     * @param string $url
     * @param string $title
     * @param string $urlFoundOnPage
     * @return boolean
     */
    public static function addToIndex($url, $title = null, $urlFoundOnPage = null)
    {
        $url   = \open2\crawler\frontend\classes\CrawlContainer::cleanUrl($url);
        $model = self::find()->where(['url' => $url])->exists();

        if ($model) {
            return false;
        }

        $model                    = new self();
        $model->url               = $url;
        $model->title             = StringHelper::truncate($title, 197);
        $model->url_found_on_page = $urlFoundOnPage;
        $model->crawled           = false;

        $model->save(false);

        return $model;
    }

    /**
     * Add a given page to the index with status: uncrawled.
     *
     * If there url exists already in the index, false is returned.
     *
     * @param string $url
     * @param integer $processed
     * @param string $title
     * @param string $urlFoundOnPage
     * @return boolean
     */
    public static function setUrlProcessed($url, $processed = 1)
    {
        $url   = \open2\crawler\frontend\classes\CrawlContainer::cleanUrl($url);
        $model = self::findUrl($url);

        if ($model) {
            $model->processed = $processed;
            return $model->save(false);
        }

        $model                    = new self();
        $model->url               = $url;
        $model->title             = '';
        $model->url_found_on_page = null;
        $model->crawled           = false;
        $model->processed         = $processed;

        return $model->save(false);
    }
}