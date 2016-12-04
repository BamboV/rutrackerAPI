<?php

namespace BamboV\RutrackerAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use BamboV\RutrackerAPI\Interfaces\SenderInterface;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class GuzzleSender implements SenderInterface
{
    /**
     * @param Request $request
     * @param bool $allowRedirect
     *
     * @return Response
     */
    public function send(Request $request, bool $allowRedirect = false):Response
    {
        $client = new Client(['allow_redirects' => $allowRedirect]);

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
