<?php

namespace Kirby\Cms;

use Kirby\Data\Yaml;
use PHPUnit\Framework\TestCase;

class BlocksTest extends TestCase
{
    protected $page;

    public function setUp(): void
    {
        $this->app = new App([
            'roots' => [
                'index' => '/dev/null',
            ],
        ]);

        $this->page = new Page(['slug' => 'test']);
    }

    public function testFactoryFromLayouts()
    {
        $layouts = [
            [
                'columns' => [
                    [
                        'blocks' => [
                            [
                                'type' => 'heading'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'columns' => [
                    [
                        'blocks' => [
                            [
                                'type' => 'text'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $blocks = Blocks::factory($layouts);

        $this->assertCount(2, $blocks);
        $this->assertSame('heading', $blocks->first()->type());
        $this->assertSame('text', $blocks->last()->type());
    }

    public function testParseJson()
    {
        $input = [
            [
                'type' => 'heading'
            ]
        ];

        $result = Blocks::parse(json_encode($input));
        $this->assertSame($result, $input);
    }

    public function testParseYaml()
    {
        $input = [
            [
                'type' => 'heading'
            ]
        ];

        $result = Blocks::parse(Yaml::encode($input));
        $this->assertSame($result, $input);
    }

    public function testParseHtml()
    {
        $input = '<h1>Test</h1>';
        $expected = [
            [
                'type' => 'heading',
                'content' => [
                    'level' => 'h1',
                    'text' => 'Test'
                ]
            ]
        ];

        $result = Blocks::parse($input);
        $this->assertSame($result, $expected);
    }

    public function testToHtml()
    {
        $blocks = Blocks::factory([
            [
                'content' => [
                    'text' => 'Hello world'
                ],
                'type' => 'heading'
            ],
            [
                'content' => [
                    'text' => 'Nice blocks'
                ],
                'type' => 'text'
            ],
        ]);

        $expected = "<h2>Hello world</h2>\nNice blocks";

        $this->assertSame($expected, $blocks->toHtml());
    }

    public function testToHtmlWithCustomSnippets()
    {
        $this->app = new App([
            'roots' => [
                'index' => '/dev/null',
                'snippets' => __DIR__ . '/fixtures/snippets'
            ],
        ]);

        $blocks = Blocks::factory([
            [
                'content' => [
                    'text' => 'Hello world'
                ],
                'type' => 'heading'
            ],
            [
                'content' => [
                    'text' => 'Nice blocks'
                ],
                'type' => 'text'
            ],
        ]);

        $expected = "<h1 class=\"custom-heading\">Hello world</h1>\n<p class=\"custom-text\">Nice blocks</p>\n";

        $this->assertSame($expected, $blocks->toHtml());
    }
}
