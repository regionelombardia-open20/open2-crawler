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

namespace crawlerests\data\fixtures;

use yii\test\ActiveFixture;
use luya\testsuite\fixtures\NgRestModelFixture;

class IndexFixture extends NgRestModelFixture
{
    public $modelClass = 'open2\crawler\models\Index';

    public function getData()
    {
        return [
            'index1' => [
                'url' => 'index1.php',
                'title' => 'aaa',
                'content' => 'bbb',
                'description' => 'ccc',
                'language_info' => 'en',
            ],
            'index2' => [
                'url' => 'index2.php',
                'title' => 'index2',
                'content' => 'words some other drinking words and now bug is the word barfoo',
                'description' => 'index2',
                'language_info' => 'en',
            ],
            'index3' => [
                'url' => 'index3.php',
                'title' => 'index3',
                'content' => 'stem drink stem find stem barfoo',
                'description' => 'index3',
                'language_info' => 'en',
            ],
            'index4' => [
                'url' => 'index4.php',
                'title' => 'index4',
                'content' => 'twowords',
                'description' => 'index4',
                'language_info' => 'en',
            ],

            'index7' => [
                'url' => 'index7.php',
                'title' => 'index7',
                'content' => 'item',
                'description' => 'index7',
                'language_info' => 'en',
            ],
            'index6' => [
                'url' => 'index6/else/item',
                'title' => 'index5',
                'content' => 'item',
                'description' => 'index5',
                'language_info' => 'en',
            ],
            'index5' => [
                'url' => 'index5/item',
                'title' => 'index5',
                'content' => 'item',
                'description' => 'index5',
                'language_info' => 'en',
            ],
            'index8' => [
                'url' => 'offnungszeiten.php',
                'title' => 'offnungszeiten',
                'content' => '&Ouml;ffnungszeiten &ouml;ffnungszeiten Öffnungszeiten öffnungszeiten',
                'language_info' => 'de',
            ]
        ];
    }
}
