<?php

use Geekgarden\GithubLogger\GithubLogger;
use PHPUnit\Framework\TestCase;

class GithubLoggerTest extends TestCase
{
    public function testReport()
    {
        $reporter = new GithubLogger(config('github_error_reporter.repo'), config('github_error_reporter.token'));
        $result = $reporter->report('Test Issue', 'This is a test issue.');

        $this->assertArrayHasKey('url', $result);
    }
}
