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

use yii\db\Migration;

class m150727_104346_crawler_index extends Migration
{
    public function safeUp()
    {
        $this->createTable('crawler_index', [
            'id' => $this->primaryKey(),
            'url' => $this->string(200)->notNull()->unique(),
            'title' => $this->string(200),
            'content' => $this->text(),
            'description' => $this->text(),
            'language_info' => $this->string(80),
            'url_found_on_page' => $this->string(255),
            'group' => $this->string(120),
            'added_to_index' => $this->integer(11)->defaultValue(0),
            'last_update' => $this->integer(11)->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('crawler_index');
    }
}
