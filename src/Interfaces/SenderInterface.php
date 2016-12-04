<?php

namespace BamboV\RutrackerAPI\Interfaces;

use BamboV\RutrackerAPI\Request;
use BamboV\RutrackerAPI\Response;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface SenderInterface
{
    /**
     * @param Request $request
     *
     * @param bool $allowRedirect
     * @return Response
     */
    public function send(Request $request, bool $allowRedirect = false):Response;
}
