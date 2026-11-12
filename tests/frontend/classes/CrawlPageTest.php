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

namespace crawlerests\frontend\classes;

use open2\crawler\frontend\classes\CrawlPage;
use Symfony\Component\DomCrawler\Crawler;
use crawlerests\CrawlerTestCase;

class CrawlPageTest extends CrawlerTestCase
{
    public $object;
    
    public function afterSetup()
    {
        $this->object = new CrawlPage(['baseUrl' => 'http://localhost', 'pageUrl' => 'http://localhost', 'verbose' => false, 'useH1' => false]);
        $this->object->setCrawler(new Crawler(file_get_contents('tests/data/luyaio.html')));
    }
    
    public function testCrawlerLinks()
    {
        $this->assertSame(149, count($this->object->getLinks()));
    }
    
    public function testLanguage()
    {
        $this->assertSame('en', $this->object->getLanguageInfo());
    }
    
    public function testTitle()
    {
        $this->assertSame('Title Tag', $this->object->getTitle());
    }
    
    public function testTitleH1()
    {
        $this->assertSame('Guide', $this->object->getTitleH1());
    }
    
    public function testFalseCrawlerTitle()
    {
        $this->assertFalse($this->object->getTitleCrawlerTag());
    }
    
    public function testGetGroup()
    {
        $this->assertSame('grp', $this->object->getGroup());
    }
    
    public function testSuccessCrawlerTitle()
    {
        $this->object->setCrawler(new Crawler(file_get_contents('tests/data/titletest.html')));
        $this->assertSame('Crawler Title', $this->object->getTitleCrawlerTag());
        
        $this->assertSame('Heading 1', CrawlPage::cleanupString($this->object->getCrawlerHtml()));

        $this->assertSame('Heading 1 Title', $this->object->getContent());
    }

    public function testRemoveScriptTagsInContent()
    {
        $this->object->setCrawler(new Crawler('1<script>2</script>3'));
    
        $this->assertSame('<p>13</p>', $this->object->getCrawlerHtml());
    }
    
    public function testGetMetaDescription()
    {
        $this->object->setCrawler(new Crawler(file_get_contents('tests/data/metatest.html')));
        
        $this->assertSame('a', $this->object->getMetaDescription());
    }
    
    public function testGetMetaKeywords()
    {
        $this->object->setCrawler(new Crawler(file_get_contents('tests/data/metatest.html')));
         
        $this->assertSame('c d', $this->object->getMetaKeywords());
    }
    
    public function testGetTitleTag()
    {
        $this->object->setCrawler(new Crawler(file_get_contents('tests/data/metatest.html')));
        
        $this->assertSame('Title', $this->object->getTitleTag());
    }

    public function testHtmlEncoding()
    {
        $this->object->setCrawler(new Crawler(file_get_contents('tests/data/htmlencode.html')));
        
        $this->assertSame('Öffnungszeiten öffnungszeiten Öffnungszeiten öffnungszeiten', $this->object->getContent());
    }
}
