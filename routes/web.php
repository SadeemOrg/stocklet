<?php

use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;


Route::controller(StripePaymentController::class)->group(function () {
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});


Route::get('/payment', function () {
    return view('templates.basic.payment');
});

Route::get('/success_subscription', function () {
    return view('templates.basic.success_subscription');
});
Route::get('/privacy_policy', function () {
    return view('templates.basic.seller_register.privacy_policy');
});
Route::get('/profile', function () {
    return view('templates.basic.seller_register.profile');
});
Route::get('/success_register', function () {
    return view('templates.basic.seller_register.success_register');
});


Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{ticket}', 'replyTicket')->name('reply');
    Route::post('close/{ticket}', 'closeTicket')->name('close');
    Route::get('download/{ticket}', 'ticketDownload')->name('download');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

//image
Route::controller('ImageController')->name('image.')->prefix('image')->group(function () {
    Route::get('download/{id}', 'download')->name('download');
});
Route::controller('videoController')->name('video.')->prefix('video')->group(function () {
    Route::get('download/{id}', 'download')->name('download');
});

Route::controller('SiteController')->group(function () {
    //plans
    Route::get('/plans', 'plans')->name('plans');

    //collections
    Route::get('/collections', 'collections')->name('collections');
    Route::get('/collection/{slug}/{id}/detail', 'collectionDetail')->name('collection.detail');

    //members
    Route::get('/members', 'members')->name('members');
    Route::get('/{username}/images', 'memberImages')->name('member.images');
    Route::get('/{username}/collections', 'memberCollections')->name('member.collections');
    Route::get('/{username}/about', 'memberFollowerFollowings')->name('member.followers.followings');
    Route::get('/{username}/followers', 'memberFollowers')->name('member.followers');
    Route::get('/{username}/followings', 'memberFollowings')->name('member.followings');

    //images
    Route::get('images/{scope}', 'images')->name('images');
    Route::get('image/{slug}/{id}', 'imageDetail')->name('image.detail');

    //videos
    Route::get('videos/{scope}', 'videos')->name('videos');
    Route::get('video/{slug}/{id}', 'videoDetail')->name('video.detail');

    //search
    Route::get('search', 'search')->name('search');

    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/txt/download', 'txtDownload')->name('txt.download');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');


    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});
