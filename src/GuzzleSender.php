<?php

namespace VovanSoft\RutrackerAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use VovanSoft\RutrackerAPI\Interfaces\SenderInterface;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class GuzzleSender implements SenderInterface
{

    public function send(Request $request):Response
    {
        $client = new Client(['allow_redirects' => false]);
//        var_dump($request->getCookies());
//        $cookies = new CookieJar();
//        $cookies->setCookie();
        $options = [];
        $options['form_params'] = $request->getData();

        if($request->getCookies()) {
            $options['headers'] = ['Cookie' => $request->getCookies()];
        }

        $resp = $client->request($request->getMethod(), $request->getUrl(), $options);

        $stream = $resp->getBody();

        $bodyString = '';

        while ($buf = $stream->read(1024)) {
            $bodyString.=$buf;
        }
        return new Response($resp->getStatusCode(), $bodyString, $resp->getHeader('set-cookie'));
    }
}

//new CookieJar(true, array_map(function($item){
//    var_dump(explode(';',$item));
//    return explode(';',$item);
//},$request->getCookies()))
