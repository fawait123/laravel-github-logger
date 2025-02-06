<?php

namespace Geekgarden\GithubLogger;

use GuzzleHttp\Client;

class GithubLogger
{
    protected $client;
    protected $repo;
    protected $owner;
    protected $token;

    public function __construct(string $repo, string $token)
    {
        $this->client = new Client([
            'base_uri' => 'https://api.github.com/',
            'headers' => [
                'Authorization' => "token {$token}",
                'Accept'        => 'application/vnd.github.v3+json',
            ]
        ]);
        $this->repo = $repo;
        $this->token = $token;
    }

    public function report(string $title, string $body)
    {
        $response = $this->client->post("repos/{$this->repo}/issues", [
            'json' => [
                'title' => $title,
                'body'  => $body,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
