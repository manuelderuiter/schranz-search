<?php

declare(strict_types=1);

/*
 * This file is part of the Schranz Search package.
 *
 * (c) Alexander Schranz <alexander@sulu.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Schranz\Search\SEAL\Testing;

use Schranz\Search\SEAL\Schema\Field;
use Schranz\Search\SEAL\Schema\Index;
use Schranz\Search\SEAL\Schema\Schema;

final class TestingHelper
{
    public const INDEX_COMPLEX = 'complex';

    public const INDEX_SIMPLE = 'simple';

    private function __construct()
    {
    }

    public static function createSchema(): Schema
    {
        $prefix = \getenv('TEST_INDEX_PREFIX') ?: $_ENV['TEST_INDEX_PREFIX'] ?? 'test_';

        $complexFields = [
            'uuid' => new Field\IdentifierField('uuid'),
            'title' => new Field\TextField('title'),
            'header' => new Field\TypedField('header', 'type', [
                'image' => [
                    'media' => new Field\IntegerField('media'),
                ],
                'video' => [
                    'media' => new Field\TextField('media', searchable: false),
                ],
            ]),
            'article' => new Field\TextField('article'),
            'blocks' => new Field\TypedField('blocks', 'type', [
                'text' => [
                    'title' => new Field\TextField('title'),
                    'description' => new Field\TextField('description'),
                    'media' => new Field\IntegerField('media', multiple: true),
                ],
                'embed' => [
                    'title' => new Field\TextField('title'),
                    'media' => new Field\TextField('media', searchable: false),
                ],
            ], multiple: true),
            'footer' => new Field\ObjectField('footer', [
                'title' => new Field\TextField('title'),
            ]),
            'created' => new Field\DateTimeField('created', filterable: true, sortable: true),
            'commentsCount' => new Field\IntegerField('commentsCount', filterable: true, sortable: true),
            'rating' => new Field\FloatField('rating', filterable: true, sortable: true),
            'comments' => new Field\ObjectField('comments', [
                'email' => new Field\TextField('email', searchable: false),
                'text' => new Field\TextField('text'),
            ], multiple: true),
            'tags' => new Field\TextField('tags', multiple: true, filterable: true),
            'categoryIds' => new Field\IntegerField('categoryIds', multiple: true, filterable: true),
        ];

        $simpleFields = [
            'id' => new Field\IdentifierField('id'),
            'title' => new Field\TextField('title'),
            'is_online' => new Field\BooleanField('is_online', filterable: true),
            'author' => new Field\TextField('author', filterable: true),
        ];

        $complexIndex = new Index($prefix . 'complex', $complexFields);
        $simpleIndex = new Index($prefix . 'simple', $simpleFields);

        return new Schema([
            self::INDEX_COMPLEX => $complexIndex,
            self::INDEX_SIMPLE => $simpleIndex,
        ]);
    }

    /**
     * @return array<array{
     *     uuid: string,
     *     title?: string|null,
     *     article?: string|null,
     *     blocks?: array<array{
     *          type: string,
     *          title?: string|null,
     *          description?: string|null,
     *          media?: int[]|string,
     *     }>,
     *     created?: string|null,
     *     commentsCount?: int|null,
     *     rating?: float|null,
     *     comments?: array<array{
     *         email?: string|null,
     *         text?: string|null,
     *     }>|null,
     *     tags?: string[]|null,
     *     categoryIds?: int[]|null,
     * }>
     */
    public static function createComplexFixtures(): array
    {
        return [
            [
                'uuid' => '23b30f01-d8fd-4dca-b36a-4710e360a965',
                'title' => 'New Blog',
                'header' => [
                    'type' => 'image',
                    'media' => 1,
                ],
                'article' => '<article><h2>New Subtitle</h2><p>A html field with some content</p></article>',
                'blocks' => [
                    [
                        'type' => 'text',
                        'title' => 'Titel',
                        'description' => '<p>Description</p>',
                        'media' => [3, 4],
                    ],
                    [
                        'type' => 'text',
                        'title' => 'Titel 2',
                    ],
                    [
                        'type' => 'embed',
                        'title' => 'Video',
                        'media' => 'https://www.youtube.com/watch?v=iYM2zFP3Zn0',
                    ],
                    [
                        'type' => 'text',
                        'title' => 'Titel 4',
                        'description' => '<p>Description 4</p>',
                        'media' => [3, 4],
                    ],
                ],
                'footer' => [
                    'title' => 'New Footer',
                ],
                'created' => '2022-01-24T12:00:00+01:00',
                'commentsCount' => 2,
                'rating' => 3.5,
                'comments' => [
                    [
                        'email' => 'admin.nonesearchablefield@localhost',
                        'text' => 'Awesome blog!',
                    ],
                    [
                        'email' => 'example.nonesearchablefield@localhost',
                        'text' => 'Like this blog!',
                    ],
                ],
                'tags' => ['Tech', 'UI'],
                'categoryIds' => [1, 2],
            ],
            [
                'uuid' => '79848403-c1a1-4420-bcc2-06ed537e0d4d',
                'title' => 'Other Blog',
                'header' => [
                    'type' => 'video',
                    'media' => 'https://www.youtube.com/watch?v=iYM2zFP3Zn0',
                ],
                'article' => '<article><h2>Other Subtitle</h2><p>A html field with some content</p></article>',
                'footer' => [
                    'title' => 'Other Footer',
                ],
                'created' => '2022-12-26T12:00:00+01:00',
                'commentsCount' => 0,
                'rating' => 2.5,
                'comments' => [],
                'tags' => ['UI', 'UX'],
                'categoryIds' => [2, 3],
            ],
            [
                'uuid' => '8d90e7d9-2b56-4980-90ce-f91d020cee53',
                'title' => 'Other Thing',
                'article' => '<article><h2>Other Thing</h2><p>A html field with some content</p></article>',
                'footer' => [
                    'title' => 'Other Footer',
                ],
                'created' => '2023-02-03T12:00:00+01:00',
                'commentsCount' => 0,
                'comments' => [],
                'tags' => ['Tech', 'UX'],
                'categoryIds' => [3, 4],
            ],
            [
                'uuid' => '97cd3e94-c17f-4c11-a22b-d9da2e5318cd',
            ],
        ];
    }

    /**
     * @return array<array{
     *     id: string,
     *     title?: string|null,
     *     is_online?: bool,
     *     author?: string
     * }>
     */
    public static function createSimpleFixtures(): array
    {
        return [
            [
                'id' => '1',
                'title' => 'Simple Title',
            ],
            [
                'id' => '2',
                'title' => 'Other Title',
            ],
            [
                'id' => '3',
            ],
            [
                'id' => '4',
                'title' => 'Simple Title',
                'is_online' => true,
                'author' => 'John Doe',
            ],
            [
                'id' => '5',
                'title' => 'Other Title',
                'is_online' => false,
            ],
            [
                'id' => '6',
                'title' => 'Simple Title',
                'is_online' => true,
                'author' => 'Jane Doe',
            ],
            [
                'id' => '7',
                'title' => 'Simple Title',
                'author' => 'A.',
            ],
        ];
    }
}
