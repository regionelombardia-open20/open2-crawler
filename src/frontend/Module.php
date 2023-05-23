<?php

namespace open2\crawler\frontend;

/**
 * LUYA Crawler Frontend Module.
 *
 * The Crawler will create an index with all pages based on your defined `baseUrl`. You can run the crawler by using the command
 *
 * ```sh
 * ./vendor/bin/luya crawler/crawl
 * ```
 *
 * This will create an index where you can search inside (See helper methods in `open2\crawler\models\Index` to find by query methods).
 * You should run your crawler command by a cronjob to make sure your page will be crawled everynight and the users have a fresh index.
 *
 *
 * @since 1.0.0
 */
final class Module extends \luya\base\Module
{
    /**
     * @var boolean This module enables by default to lookup for view files in the apps/views folder.
     */
    public $useAppViewPath = true;

    /**
     *
     * @var type
     */
    public $performance = true;

    /**
     * @var string The based Url where the crawler should start to lookup for pages, the crawler only allowes
     * links which matches the base url. It doenst matter if you have a trailing slash or not, the module is taking
     * care of this.
     *
     * So on a localhost your base url could look like this:
     *
     * ```php
     * 'baseUrl' => 'http://localhost/luya-kickstarter/public_html/',
     * ```
     *
     * If you are on a production/preproduction server the url in your config could look like this:
     *
     * ```php
     * 'baseUrl' => 'https://luya.io',
     * ```
     */
    public $baseUrl;

    /**
     *
     * @var type
     */
     public $suffixBaseUrlLang = ['en/eng'];
    
    /**
     * @var array An array with regular expression (including delimiters) which will be applied to found links so you can
     * filter several urls which should not be followed by the crawler.
     *
     * Examples:
     *
     * ```php
     * 'filterRegex' => [
     *     '/\.\//i',           // filter all links with a dot inside
     *     '/agenda\//i',       // filter all pages who contains "agenda/"
     * ],
     * ```
     */
    public $filterRegex = [];
    
    
    /**
     * @var array|boolean Define an array of extension where the links should automatically not follow in order to save memory.
     * If you like to disable this feature (small pages) you can set `false`.
     */
    public $doNotFollowExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'tiff', 'tif', 'eps', 'bmp', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'csv', 'zip'];
    
    /**
     * @var boolean By default the title tag will be used for the page name, if `$useH1` is enabled the title for the page will be replaced by the h1 tag if found, oterwise
     * only the title tag is used for titles.
     */
    public $useH1 = false;
    
    /**
     * @var array E-Mail addresses array with recipients for the statistic command
     */
    public $statisticRecipients = [];
    
    /**
     * @var integer Number of pages
     */
    public $searchResultPageSize = 25;

    /**
     *
     * @var boolean 
     */ 
    public $encodeUrl = false;

    public $skipUrl = [
        '/sondaggi/frontend/compila',
        'en/404',
        'en/homepage',
        'attachments/file/view',
        ];

    /**
     *
     * @var type
     */
    public $maxNumberUrls = 15000;

    /**
     * 
     * @var type
     */
    public $notDeleteOldResult = false;

    /**
     * Set to true the first time, then execute the crawler every day
     * @var type
     */
    public $initialization = true;
    
    /**
     * @inheritdoc
     */
    public $urlRules = [
        ['pattern' => 'crawler', 'route' => 'crawler/default'],
    ];

    public static function onLoad()
    {
        self::registerTranslation('crawler', static::staticBasePath() . '/messages', [
            'crawler' => 'crawler.php',
        ]);
    }

    public static function t($message, array $params = [])
    {
        return parent::baseT('crawler', $message, $params);
    }
}
