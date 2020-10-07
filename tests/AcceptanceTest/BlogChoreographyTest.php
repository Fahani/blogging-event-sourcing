<?php

declare(strict_types=1);


namespace App\Tests\AcceptanceTest;


use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BlogChoreographyTest extends WebTestCase
{
    private KernelBrowser $client;

    public static function setUpBeforeClass()
    {
        $client = new Client();
        $client->request('DELETE', 'http://project-blogging-elasticsearch:9200/authorreadmodel');
        $client->request('DELETE', 'http://project-blogging-elasticsearch:9200/postreadmodel');

        $client->request('PUT', 'http://project-blogging-elasticsearch:9200/authorreadmodel');
        $client->request('PUT', 'http://project-blogging-elasticsearch:9200/postreadmodel');
    }

    protected function setUp()
    {
        $this->client = self::createClient();
    }

    /**
     * @test
     */
    public function saveAuthor(): void
    {
        $this->client->request(
            'POST',
            '/author',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"id":"ee6b7567-a76b-4f7e-9c94-9e620ec96798","name":"Name","surname":"Surname"}'
        );

        self::assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }


    /**
     * @test
     */
    public function savePost(): void
    {

        $this->client->request(
            'POST',
            '/author',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"id":"ee6b7567-a76b-4f7e-9c94-9e620ec96798","name":"Name","surname":"Surname"}'
        );

        $this->client->request(
            'POST',
            '/post',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"id":"44d5b99d-d26f-433f-bdbf-9bd808e95499", "title":"Title", "description":"description", "content":"content", "authorId":"ee6b7567-a76b-4f7e-9c94-9e620ec96798"}'
        );


        self::assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function fetchPost(): void
    {
        $this->client->request(
            'GET',
            '/post/44d5b99d-d26f-433f-bdbf-9bd808e95499?includeAuthor=true',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $postInfoDecoded = json_decode($this->client->getResponse()->getContent(), true);

        self::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        self::assertEquals('ee6b7567-a76b-4f7e-9c94-9e620ec96798', $postInfoDecoded['author']['id']);
    }

    public static function tearDownAfterClass(): void
    {
        $client = new Client();
        $client->request('DELETE', 'http://project-blogging-elasticsearch:9200/authorreadmodel');
        $client->request('DELETE', 'http://project-blogging-elasticsearch:9200/postreadmodel');

        $client->request('PUT', 'http://project-blogging-elasticsearch:9200/authorreadmodel');
        $client->request('PUT', 'http://project-blogging-elasticsearch:9200/postreadmodel');

    }
}
