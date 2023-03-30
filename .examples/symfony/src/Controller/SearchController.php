<?php

declare(strict_types=1);

namespace App\Controller;

use Schranz\Search\SEAL\Adapter\AdapterInterface;
use Schranz\Search\SEAL\Engine;
use Schranz\Search\SEAL\EngineRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController
{
    #[Route('/', name: 'home')]
    public function index(EngineRegistry $engineRegistry): Response
    {
        $engineNames = implode(', ', \array_keys([...$engineRegistry->getEngines()]));

        return new Response(
            <<<HTML
            <!doctype html>
            <html>
                <head>
                    <title>Search Engines</title>
                </head>
                <body>
                    <ul>
                        <li><a href="/algolia">Algolia</a></li>
                        <li><a href="/elasticsearch">Elasticsearch</a></li>
                        <li><a href="/meilisearch">Meilisearch</a></li>
                        <li><a href="/memory">Memory</a></li>
                        <li><a href="/opensearch">Opensearch</a></li>
                        <li><a href="/redisearch">RediSearch</a></li>
                        <li><a href="/solr">Solr</a></li>
                        <li><a href="/typesense">Typesense</a></li>
                        <li>....</li>
                        <li><a href="/multi">Multi</a></li>
                        <li><a href="/read-write">Read-Write</a></li>
                    </ul>
                    
                    <div>
                        <strong>Registred Engines</strong>: $engineNames
                    </div>
                </body>
            </html>
            HTML
        );
    }

    #[Route('/algolia', name: 'algolia')]
    public function algolia(Engine $algoliaEngine): Response
    {
        $class = $this->getAdapterClass($algoliaEngine);

        return new Response(
            <<<HTML
            <!doctype html>
            <html>
                <head>
                    <title>Algolia</title>
                </head>
                <body>
                    <h1>$class</h1>
                </body>
            </html>
HTML
        );
    }

    #[Route('/meilisearch', name: 'meilisearch')]
    public function meilisearch(Engine $meilisearchEngine): Response
    {
        $class = $this->getAdapterClass($meilisearchEngine);

        return new Response(
            <<<HTML
            <!doctype html>
            <html>
                <head>
                    <title>Meilisearch</title>
                </head>
                <body>
                    <h1>$class</h1>
                </body>
            </html>
HTML
        );
    }

    #[Route('/elasticsearch', name: 'elasticsearch')]
    public function elasticsearch(Engine $elasticsearchEngine): Response
    {
        $class = $this->getAdapterClass($elasticsearchEngine);

        return new Response(
            <<<HTML
            <!doctype html>
            <html>
                <head>
                    <title>Elasticsearch</title>
                </head>
                <body>
                    <h1>$class</h1>
                </body>
            </html>
HTML
        );
    }

    #[Route('/memory', name: 'memory')]
    public function memory(Engine $memoryEngine): Response
    {
        $class = $this->getAdapterClass($memoryEngine);

        return new Response(
            <<<HTML
            <!doctype html>
            <html>
                <head>
                    <title>Memory</title>
                </head>
                <body>
                    <h1>$class</h1>
                </body>
            </html>
HTML
        );
    }

    #[Route('/opensearch', name: 'opensearch')]
    public function opensearch(Engine $opensearchEngine): Response
    {
        $class = $this->getAdapterClass($opensearchEngine);

        return new Response(
            <<<HTML
            <!doctype html>
            <html>
                <head>
                    <title>Opensearch</title>
                </head>
                <body>
                    <h1>$class</h1>
                </body>
            </html>
HTML
        );
    }

    #[Route('/solr', name: 'solr')]
    public function solr(Engine $solrEngine): Response
    {
        $class = $this->getAdapterClass($solrEngine);

        return new Response(
            <<<HTML
            <!doctype html>
            <html>
                <head>
                    <title>Solr</title>
                </head>
                <body>
                    <h1>$class</h1>
                </body>
            </html>
HTML
        );
    }

    #[Route('/redisearch', name: 'redisearch')]
    public function redisearch(Engine $redisearchEngine): Response
    {
        $class = $this->getAdapterClass($redisearchEngine);

        return new Response(
            <<<HTML
            <!doctype html>
            <html>
                <head>
                    <title>RediSearch</title>
                </head>
                <body>
                    <h1>$class</h1>
                </body>
            </html>
HTML
        );
    }

    #[Route('/typesense', name: 'typesense')]
    public function typesense(Engine $typesenseEngine): Response
    {
        $class = $this->getAdapterClass($typesenseEngine);

        return new Response(
            <<<HTML
            <!doctype html>
            <html>
                <head>
                    <title>Typesense</title>
                </head>
                <body>
                    <h1>$class</h1>
                </body>
            </html>
HTML
        );
    }

    #[Route('/multi', name: 'multi')]
    public function multi(Engine $multiEngine): Response
    {
        $class = $this->getAdapterClass($multiEngine);

        return new Response(
            <<<HTML
            <!doctype html>
            <html>
                <head>
                    <title>Multi</title>
                </head>
                <body>
                    <h1>$class</h1>
                </body>
            </html>
HTML
        );
    }

    #[Route('/read-write', name: 'read-write')]
    public function readWrite(Engine $readWriteEngine): Response
    {
        $class = $this->getAdapterClass($readWriteEngine);

        return new Response(
            <<<HTML
            <!doctype html>
            <html>
                <head>
                    <title>Read-Write</title>
                </head>
                <body>
                    <h1>$class</h1>
                </body>
            </html>
HTML
        );
    }

    private function getAdapterClass(Engine $engine): string
    {
        $reflection = new \ReflectionClass($engine);
        $propertyReflection = $reflection->getProperty('adapter');
        $propertyReflection->setAccessible(true);

        /** @var AdapterInterface $object */
        $object = $propertyReflection->getValue($engine);

        return $object::class;
    }
}
