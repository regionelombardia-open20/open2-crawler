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

use yii\db\ActiveRecord;

/**
 * This is the model class for table "crawler_click".
 *
 * @property int $id
 * @property int $searchdata_id
 * @property int $position
 * @property int $index_id
 * @property int $timestamp
 *
 * @since 1.0.1
 */
class Click extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crawler_click';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['searchdata_id', 'position', 'index_id', 'timestamp'], 'required'],
            [['searchdata_id', 'position', 'index_id', 'timestamp'], 'integer'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'searchdata_id' => 'Searchdata ID',
            'position' => 'Position',
            'index_id' => 'Index ID',
            'timestamp' => 'Timestamp',
        ];
    }
}
