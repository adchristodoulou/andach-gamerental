<?php

namespace App\Http\Controllers;

use App\Game;
use App\Page;
use App\Plan;
use Sitemap;

class SitemapController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        foreach ($pages as $page)
        {
        	Sitemap::addSitemap(route('page.show', $page->slug));
        	Sitemap::addTag(route('page.show', $page->slug), $page->updated_at, 'daily', '0.8');
        }

        $games = Game::all();
        foreach ($games as $game)
        {
        	Sitemap::addSitemap(route('game.show', $game->slug));
        	Sitemap::addTag(route('game.show', $game->slug), $game->updated_at, 'daily', '0.7');
        }

        $plans = Plan::all();
        foreach ($plans as $plan)
        {
        	Sitemap::addSitemap(route('plan.show', $plan->slug));
        	Sitemap::addTag(route('plan.show', $plan->slug), $plan->updated_at, 'daily', '0.5');
        }

        // Return the sitemap to the client.
        return Sitemap::render();
    }
}