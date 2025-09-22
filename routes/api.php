<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);

Route::middleware('auth:sanctum')->group(function () {
    Route::put('changePassword', [AuthController::class, 'changePassword']);
    Route::put('posts/{id}', [PostController::class, 'update']);
    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/{id}', [PostController::class, 'show']);
    Route::post('posts', [PostController::class, 'create']);
    Route::delete('posts/{id}', [PostController::class, 'delete']);

    Route::get('posts/download/{id}', [DownloadController::class, 'download']);
    Route::post('upload', [UploadController::class, 'upload']);

    Route::post('/stripe/create-payment-intent', [StripePaymentController::class, 'createPaymentIntent']);
});
