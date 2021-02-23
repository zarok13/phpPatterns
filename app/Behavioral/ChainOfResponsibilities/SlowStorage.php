<?php

namespace App\Behavioral\ChainOfResponsibilities;


use Psr\Http\Message\RequestInterface;

// SlowDatabaseHandler

class SlowStorage extends Handler
{
    protected function processing(RequestInterface $request): ?string
    {
        // this is a mockup, in production code you would ask a slow (compared to in-memory) DB for the results

        return 'Hello World!';
    }
}