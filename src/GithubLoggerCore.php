<?php

namespace Geekgarden\GithubLogger;


class GithubLoggerCore
{
    public function __get($property)
    {
        $this->{$property} = 'disini property';
    }
}
