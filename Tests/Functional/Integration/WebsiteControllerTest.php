<?php

namespace TheCocktail\Bundle\MegaMenuBundle\Tests\Functional\Integration;

use Sulu\Bundle\TestBundle\Testing\WebsiteTestCase;

class WebsiteControllerTest extends WebsiteTestCase
{
    public function testHomepage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testExpectedMegamenus(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $megamenus = $crawler->filter('body')->children('.megamenu');

        $this->assertSame(2, $megamenus->count());
    }

    public function testExpectedSectionsMenu(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $header = $crawler->filter('body')->children('.megamenu-header > ul');
        $footer = $crawler->filter('body')->children('.megamenu-footer > ul');

        $this->assertSame(1, $header->count());
        $this->assertSame(1, $footer->count());
    }


    public function testExpectedHeaderSectionChilds(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $header = $crawler->filter('body')->children('.megamenu-header > ul > li.header__menu-item > ul');

        $items = $header->filter('.header__menu-item');

        $this->assertSame(5, $items->count());
    }

    public function testExpectedFooterSectionChilds(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $footer = $crawler->filter('body')->children('.megamenu-footer > ul > li.footer__menu-item > ul');

        $items = $footer->filter('.footer__menu-item');

        $this->assertSame(5, $items->count());
    }
}
