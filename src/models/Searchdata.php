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

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\aws\DetailViewActiveWindow;

/**
 * Searchdata contains Search Queries from Users.
 *
 * This table represents all search queries made by the users from the frontend. This is also used in order to
 * send weekly search report.
 *
 * @property integer $id
 * @property string $query
 * @property integer $results
 * @property integer $timestamp
 * @property string $language
 *
 * @since 1.0.0
 */
class Searchdata extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crawler_searchdata';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-crawler-searchdata';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'query' => Yii::t('app', 'Query'),
            'results' => Yii::t('app', 'Results'),
            'timestamp' => Yii::t('app', 'Timestamp'),
            'language' => Yii::t('app', 'Language'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['query', 'timestamp'], 'required'],
            [['results', 'timestamp'], 'integer'],
            [['query'], 'string', 'max' => 120],
            [['language'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['query', 'language'];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'query' => 'text',
            'results' => 'number',
            'timestamp' => 'datetime',
            'language' => 'text',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['query', 'results', 'timestamp', 'language']],
            ['delete', true],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestActiveWindows()
    {
        return [
            ['class' => DetailViewActiveWindow::class, 'attributes' => [
               'language', 'query', 'results', 'timestamp:date',
            ]],
        ];
    }
}
