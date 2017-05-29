<?php
namespace Kizi\Admin\Crawler;

use App\Http\Requests;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

class Main {
   /**
     * crawl a link
     * @param $link
     * @param bool $redirect
     * @return string
     **/
    public static function crawlerLink($link)
    {
        set_time_limit(0);
        try {
            $config = [
              'proxy' => [
                  'http' => '59.127.154.78:80'
              ],
              'verify' => false,
              'decode_content' => false
            ];
            $client = new Client($config);
            $response = $client->request('GET', $link);
            if ($response->getStatusCode() == '200') {
                return $response->getBody()->getContents();
            }
        } catch (TransferException $e) {
            return 'Caught exception: '.  $e->getMessage();
        }
    }
  }
?>
