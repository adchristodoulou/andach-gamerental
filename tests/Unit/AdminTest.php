<?php

namespace Tests\Unit;

use App\System;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/admin');
        $response->assertSee('ADMIN DASHBOARD');
    }

    public function test_assignmentRun()
    {
        //Test in AssignmentRunTest
        $this->assertTrue(true);
    }

    public function test_confirmAssignments()
    {
        //Test in AssignmentRunTest
        $this->assertTrue(true);
    }

    public function test_gameIndex()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/admin/games');
        $response->assertSee('TEST GAME IN STOCK');
        $response->assertSee('TEST GAME OUT OF STOCK');
    }

    public function test_gameIndexPost()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->post('/admin/games-post', ['games' => ['1']]);
        $response->assertSee('Games have been successfully updated');
    }

    public function test_IGDBSearch()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/admin/igdb/final+fantasy+7');
        $response->assertSee('427 - Final Fantasy VII');
    }

    public function test_printDeliveryNote()
    {
        //Test in AssignmentRunTest
        $this->assertTrue(true);
    }

    public function test_productCreate()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/admin/product/create');
        $response->assertSee('Create Product');
    }

    public function test_productEdit()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/admin/product/edit/1');
        $response->assertSee('test-first-product');
        $response->assertSee('Name of the First Product');
        $response->assertSee('Snippet of the First Product');
        $response->assertSee('Full Text of the First Product');
        $response->assertSee('9.99');
    }

    public function test_productIndex()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/admin/product');
        $response->assertSee('Name of the First Product');
    }

    public function test_productStore()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->post('/admin/product', [
            'slug' => 'test-second-product',
            'price' => 777,
            'name' => 'Name of the Second Product',
            'snippet' => 'Snippet of the Second Product',
            'full_text' => 'Full Text of the Second Product',
            'is_vatable' => 1,
            'num_in_stock' => 0,
        ]);
        $response->assertSee('The product has been created');
        $response->assertSee('Name of the Second Product');
    }

    public function test_productUpdate()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->put('/admin/product', [
            'id' => 1,
            'slug' => 'test-secondEDIT-product',
            'price' => 888,
            'name' => 'Name of the SecondEDIT Product',
            'snippet' => 'Snippet of the SecondEDIT Product',
            'full_text' => 'Full Text of the SecondEDIT Product',
            'is_vatable' => 1,
            'num_in_stock' => 0,
        ]);
        $response->assertSee('The product has been edited');
        $response->assertSee('test-secondEDIT-product');
        $response->assertSee('Name of the SecondEDIT Product');
        $response->assertSee('Snippet of the SecondEDIT Product');
        $response->assertSee('Full Text of the SecondEDIT Product');
    }

    public function test_rentals()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/admin/rentals');
        $response->assertSee('Currently Rented Games');
    }

    public function test_rentalsUpdate()
    {
        //Test in ReturnGameTest
        $this->assertTrue(true);
    }

    public function test_sendGames()
    {
        //Test in AssignmentRunTest
        $this->assertTrue(true);
    }

    public function test_stock()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/admin/stock/1');
        $response->assertSee('TEST GAME IN STOCK');
    }

    public function test_stockIndex()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/admin/stock');
        $response->assertSee('Stock Index');
    }

    public function test_stockUpdate()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->post('/admin/stock-update', [
            'game_id' => 1,
            'date_purchased' => '2018-01-01',
            'purchase_price' => 1000,
        ]);
        $response->assertSee('The stock has successfully been updated');

        $response = $this->get('/admin/stock/1');
        $response->assertSee('2018-01-01');
        $response->assertSee('10.00');

        $response = $this->get('/admin/stock');
        $response->assertSee('2018-01-01');
        $response->assertSee('10.00');

        $response = $this->get('/game/1/edit');
        $response->assertSee('There are <b>2</b> copies of this game in stock, of which <b>0</b> are on rental, leaving <b>2</b> available.');

        $response = $this->followingRedirects()->post('/admin/stock-update', [
            'retire' => ['1'],
            'retirement_reason_id' => '1',
        ]);
        $response->assertSee('The stock has successfully been retired');

        $response = $this->get('/admin/stock/1');
        $response->assertSee(date('Y-m-d'));
        $response->assertSee('Test Retirement Reason');

        $response = $this->get('/admin/stock');
        $response->assertSee(date('Y-m-d'));

        $response = $this->get('/game/1/edit');
        $response->assertSee('There are <b>1</b> copies of this game in stock, of which <b>0</b> are on rental, leaving <b>1</b> available.');
    }

    public function test_uploadGames()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/admin/upload-games');
        $response->assertSee('Upload Games');
    }

    public function test_uploadGamesPost()
    {
        //Test in UploadStockTest
        $this->assertTrue(true);
    }

    public function test_uploadStock()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/admin/upload-stock');
        $response->assertSee('Upload Stock');
    }

    public function test_uploadStockPost()
    {
        //Test in UploadStockTest
        $this->assertTrue(true);
    }

    public function test_users()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/admin/users');
        $response->assertSee('Admin User');
        $response->assertSee('Normal User');
    }
}
