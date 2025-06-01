<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\EventList;
use App\Livewire\EventCreate;
use App\Livewire\EventDetail;
use App\Livewire\InvitationRespond;
use App\Livewire\RequisitionList;
use App\Livewire\RequisitionItemClaim;
use App\Livewire\EventGalleryUpload;
use App\Livewire\EventGalleryView;

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'events.list' : 'login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/events', EventList::class)->name('events.list');
    Route::get('/events/create', EventCreate::class)->name('events.create');
    Route::get('/events/{event}', EventDetail::class)->name('events.detail');

    Route::get('/invitations/respond/{invitation}', InvitationRespond::class)->name('invitations.respond');

    Route::get('/events/{event}/requisitions', RequisitionList::class)->name('requisitions.list');
Route::get('/requisitions/{item}/claim', RequisitionItemClaim::class)->name('requisition.item.claim');

    Route::get('/events/{event}/gallery/upload', EventGalleryUpload::class)->name('gallery.upload');
    Route::get('/events/{event}/gallery', EventGalleryView::class)->name('gallery.view');

    Route::view('/profile', 'profile')->name('profile');
});

require __DIR__ . '/auth.php';
