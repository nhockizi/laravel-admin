<?php

namespace Kizi\Admin\Commands;

use Kizi\Admin\Crawler\Main;
use Illuminate\Console\Command;
use Kizi\Admin\Auth\Database\Crawler as CrawlerDb;
use Kizi\Admin\Facades\Admin;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crawler:start {--code=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawler data form url';

    /**
     * Install directory.
     *
     * @var string
     */
    protected $directory = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
     public function __construct()
     {
         parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->initCrawler();
    }
    public function initCrawler()
    {
        set_time_limit(0);
        $code = $this->option('code');
        $dataCrawler = CrawlerDb::where(['active' => 1, 'code' => $code])->first();
        if(!isset($dataCrawler)){
            $this->info('Got empty result processing the dataset!');
            return false;
        }

        $parameUrl = str_replace('{page}', $dataCrawler->number_run, $dataCrawler->parame_url);
        $url = $dataCrawler->url.$parameUrl;
        $html = Main::crawlerLink($url);
        $crawler = new Crawler($html);
        $filter = $crawler->filter($dataCrawler->item);
        $result = array();
        if (iterator_count($filter) > 0) {
            foreach ($filter as $i => $content) {
                $cralwer = new Crawler($content);
                // $urlDetail = $cralwer->filter($dataCrawler->url_detail)->attr('href');
                // if($this->checkUrl($urlDetail) === false){
                //     $urlDetail = $dataCrawler->url . $urlDetail;
                // }
                // $htmlDetail = Main::crawlerLink($urlDetail);
                // $detail = new Crawler($htmlDetail);
                $result[$i] = array(
                    // 'images' => NULL,
                    'title' => $cralwer->filter($dataCrawler->title)->text(),
                    // 'description' => $cralwer->filter($dataCrawler->description)->text(),
                    // 'detail' => $detail->filter($dataCrawler->detail)->text(),
                );
                // if($dataCrawler->images !== '' && $i < 7){
                //     $srcImages = $cralwer->filter($dataCrawler->images)->attr('src');
                //     if($dataCrawler->images != '' && $this->checkUrl($srcImages) === true){
                //         $result[$i]['images'] = $srcImages;
                //     }
                // }
            }
            // CrawlerDb::where(['id' => $dataCrawler->id])->decrement('number_run', 1);
        } else {
            $this->info('Got empty result processing the dataset!');
        }
        dd($result);
    }
    function checkUrl($url){
        $file_headers = @get_headers($url);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            return false;
        }
        return true;
    }
}
