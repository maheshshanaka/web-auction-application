<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class AdminMiddlewareTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }


    public function handle($request, Closure $next)
    {
        if (\Auth::check()) {
            return redirect('/');
        }

        return $next($request);
    }

    


}
