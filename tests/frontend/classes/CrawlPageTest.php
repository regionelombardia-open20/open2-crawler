<?php

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
