<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/checkout', function (Request $request) {
    try {
        $charge = Stripe::charges()->create([
            'amount' => 60,
            'currency' => 'PHP',
            'source' => $request->stripeToken,
            'description' => 'Description goes here',
            'receipt_email' => $request->email,
            'metadata' => [
                'data1' => 'metadata 1',
                'data2' => 'metadata 2',
                'data3' => 'metadata 3',
            ]
        ]);

        return back()->with('success_message', 'Thank you! Your payment has been accepted.');
    } catch (CardErrorException $e) {
        return back()->withErrors('Error! ' . $e->getMessage());
    }
});
