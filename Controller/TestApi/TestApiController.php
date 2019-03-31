<?php
/**
 * Created by PhpStorm.
 * User: 常佳辉
 * Date: 2019/3/28
 * Time: 17:25
 */

namespace Controller\TestApi;

use Monolog\Handler\ErrorLogHandler;
use Monolog\Logger;
use Zipkin\Annotation;
use Zipkin\Endpoint;
use Zipkin\Samplers\BinarySampler;
use Zipkin\TracingBuilder;
use Zipkin\Reporters\Http;

use Controller\BaseController;
use GuzzleHttp\Client;

$baseDir=__DIR__.'/../../';
if(file_exists($baseDir.'function.php'))
{
    include $baseDir.'function.php';
}
else{
    renderData("Error:   file function.php not found");
}
class TestApiController extends BaseController
{
    public function getAllSongs()
    {
        $client=new Client();
        try{
            $response=$client->request("GET",'song.test.com/api/all',['timeout'=>5]);
            $data=$response->getBody()->getContents();

            include $this->baseDir.'public/static/php/displaySongs.php';
        }catch (\Exception $e)
        {
            renderData($e->getMessage());
        }
    }

    public function localLog()
    {

        $endpoint = Endpoint::createFromGlobals();

// Logger to stdout
        $logger = new Logger('log');
        $logger->pushHandler(new ErrorLogHandler());

        $reporter = new Http();
        $sampler = BinarySampler::createAsAlwaysSample();
        $tracing = TracingBuilder::create()
            ->havingLocalEndpoint($endpoint)
            ->havingSampler($sampler)
            ->havingReporter($reporter)
            ->build();

        $tracer = $tracing->getTracer();
        $span=$tracer->newTrace();
        $span->setName('wait 3 seconds');
        $span->start();

        $startTime=time();
        sleep(3);
        $endTime=time();

        $span->finish();
        $tracer->flush();
        renderData(['startTime'=>$startTime,'endTime'=>$endTime]);

    }
}