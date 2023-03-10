<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/heartbeat', fn () => response()->json(['success' => true]));

Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'email']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset']);

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'index'])
	->middleware(['signed'])->name('verification.verify');

Route::middleware('auth:sanctum')->group(function () {
	Route::get('/logout', [AuthController::class, 'logout']);

	Route::controller(QuoteController::class)->group(function () {
		Route::get('/newsfeed-quotes', 'index');
		Route::post('/quote', 'store');
		Route::put('/quote/{quote}', 'update');
		Route::delete('/quote/{quote}', 'destroy');
	});

	Route::controller(MovieController::class)->group(function () {
		Route::get('/movie/{id}', 'get');
		Route::get('/movie', 'index');
		Route::post('/movie', 'store');
		Route::put('/movie/{movie}', 'update');
		Route::delete('/movie/{movie}', 'destroy');
	});

	Route::get('/genre', [GenreController::class, 'index']);
	Route::post('/like', [LikeController::class, 'like']);

	Route::controller(CommentController::class)->group(function () {
		Route::get('/quote/{quoteId}/comments', [CommentController::class, 'index']);
		Route::post('/comment', [CommentController::class, 'store']);
	});

	Route::controller(ProfileController::class)->group(function () {
		Route::get('/user', 'get');
		Route::put('/profile', 'update');
	});

	Route::controller(EmailController::class)->group(function () {
		Route::post('/emails', 'store');
		Route::delete('/emails/{email}', 'destroy');
		Route::post('/emails/make-primary/{email}', 'makePrimary');
	});

	Route::controller(NotificationController::class)->group(function () {
		Route::get('/notification', 'index');
		Route::put('/notification/{notification}', 'markAsRead');
		Route::post('/notification/mark-all-read', 'markAllAsRead');
	});
});
