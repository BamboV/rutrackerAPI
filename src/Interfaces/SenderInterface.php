<?php

namespace VovanSoft\RutrackerAPI\Interfaces;

use VovanSoft\RutrackerAPI\Request;
use VovanSoft\RutrackerAPI\Response;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface SenderInterface
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function send(Request $request):Response;
}
