<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\core
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
use yii\helpers\Console;

/**
 * Class m190208_114047_add_fulltextindex
 */
class m190208_114047_add_fulltextindex extends Migration
{
    const CRAWLER_BUILDER_INDEX = "{{%crawler_builder_index}}";
    const CRAWLER_INDEX         = "{{%crawler_index}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('
            ALTER TABLE `crawler_builder_index`
            ADD FULLTEXT(`url`,`title`,`content`,`description`,`language_info`,`url_found_on_page`,`group`,`content_hash`);

            ALTER TABLE `crawler_index`
            ADD FULLTEXT(`url`,`title`,`content`,`description`,`language_info`,`url_found_on_page`,`group`);


            ALTER TABLE `crawler_searchdata`
            ADD FULLTEXT(`query`,`language`);
            ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo 'No down available';
        return true;
    }
}