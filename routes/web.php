<?php

use AcitJazz\ContactUs\Http\Controllers\Backend\ContactSubmissionController;
use AcitJazz\ContactUs\Http\Controllers\Frontend\ContactSubmissionController as ContactSubmission;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth.admin'])->prefix('backend')->group(function () {

    // ContactUs
    Route::post('/contact-submission/destroy-all', [ContactSubmissionController::class, 'destroyAll'])->name('contact-submission.destroy-all')->middleware('admin_permission:Delete Contact Submission');
    Route::post('/contact-submission/{contact_submission}/delete', [ContactSubmissionController::class, 'delete'])->name('contact-submission.delete')->middleware('admin_permission:Delete Contact Submission');
    Route::post('/contact-submission/{contact_submission}/destroy', [ContactSubmissionController::class, 'destroy'])->name('contact-submission.forceDelete')->middleware('admin_permission:Delete Contact Submission');
    Route::post('/contact-submission/{contact_submission}/restore', [ContactSubmissionController::class, 'restore'])->name('contact-submission.restore')->middleware('admin_permission:Delete Contact Submission');
    Route::get('/contact-submission', [ContactSubmissionController::class, 'index'])->name('contact-submission.index')->middleware('admin_permission:View Contact Submission');
    Route::get('/contact-submission/{contact_submission}', [ContactSubmissionController::class, 'show'])->name('contact-submission.show')->middleware('admin_permission:View Contact Submission');

});
Route::middleware(['web'])->group(function () {
Route::get('/contact-us', [ContactSubmission::class, 'index'])->name('contact-us.index');
Route::post('/contact-us', [ContactSubmission::class, 'store'])->name('contact-us.store');
});