<?php

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});

// Home > Readable
Breadcrumbs::register('homeroute', function ($breadcrumbs, $readable, $route = 'home') {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($readable, route($route));
});

Breadcrumbs::register('category', function ($breadcrumbs, $category) {
    if ($category->parentCategory) {
        $breadcrumbs->parent('category', $category->parentCategory);
    } else {
        $breadcrumbs->parent('home');
    }

    $breadcrumbs->push($category->name, route('product.showcategory', $category->slug));
});

// Home > System > Rent Game
Breadcrumbs::register('game', function ($breadcrumbs, $game) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($game->system->name, route('game.search', ['system_id' => $game->system->url]));
    $breadcrumbs->push($game->name, route('game.show', $game->slug));
});

// Home > Plans > Plan
Breadcrumbs::register('plan', function ($breadcrumbs, $plan) {
    $breadcrumbs->parent('homeroute', 'All Game Rental Plans', 'plan.index');
    $breadcrumbs->push($plan->name, route('plan.show', $plan->slug));
});

// Home > GrandparentCategory > ParentCategory > Category > Product
Breadcrumbs::register('product', function ($breadcrumbs, $product, $category) {
    $breadcrumbs->parent('category', $category);
    $breadcrumbs->push($product->name, route('product.show', $product->slug));
});