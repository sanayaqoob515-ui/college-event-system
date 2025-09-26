// Language switcher
Route::get('lang/{lang}', function($lang) {
    if (in_array($lang, ['en', 'ur'])) {
        session(['locale' => $lang]);
        app()->setLocale($lang);
    }
    return back();
});
<?php
// Logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('home');
})->name('logout');
// Two-factor authentication
Route::middleware(['auth'])->group(function() {
    Route::get('/2fa', [\App\Http\Controllers\TwoFactorController::class, 'show'])->name('2fa.show');
    Route::post('/2fa/send', [\App\Http\Controllers\TwoFactorController::class, 'send'])->name('2fa.send');
    Route::post('/2fa/verify', [\App\Http\Controllers\TwoFactorController::class, 'verify'])->name('2fa.verify');
});
// Password reset
Route::get('password/reset', [\App\Http\Controllers\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [\App\Http\Controllers\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [\App\Http\Controllers\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [\App\Http\Controllers\ForgotPasswordController::class, 'reset'])->name('password.update');
// Event share log and calendar sync log
Route::post('/events/{id}/log-share', [\App\Http\Controllers\EventController::class, 'logShare'])->name('events.logShare');
Route::post('/events/{id}/log-calendar', [\App\Http\Controllers\EventController::class, 'logCalendarSync'])->name('events.logCalendar');
// Attendance (organizer only)
Route::middleware(['auth'])->group(function() {
    Route::get('/events/{id}/attendance', [\App\Http\Controllers\AttendanceController::class, 'list'])->name('attendance.list');
    Route::post('/events/{event}/attendance/{student}', [\App\Http\Controllers\AttendanceController::class, 'mark'])->name('attendance.mark');
});
// Announcements
Route::middleware(['auth'])->group(function() {
    Route::get('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [\App\Http\Controllers\AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'store'])->name('announcements.store');
});
// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function() {
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{id}/role', [\App\Http\Controllers\AdminController::class, 'updateRole'])->name('admin.updateRole');
    Route::post('/users/{id}/suspend', [\App\Http\Controllers\AdminController::class, 'suspend'])->name('admin.suspend');
    Route::post('/users/{id}/delete', [\App\Http\Controllers\AdminController::class, 'delete'])->name('admin.delete');
    Route::get('/feedbacks', [\App\Http\Controllers\AdminController::class, 'moderateFeedback'])->name('admin.feedbacks');
    Route::get('/media', [\App\Http\Controllers\AdminController::class, 'moderateMedia'])->name('admin.media');
    Route::get('/analytics', [\App\Http\Controllers\AnalyticsController::class, 'index'])->name('admin.analytics');
});

// Organizer routes (example, you can expand as needed)
Route::middleware(['auth', 'role:organizer'])->prefix('organizer')->group(function() {
    Route::get('/events', [\App\Http\Controllers\EventController::class, 'organizerEvents'])->name('organizer.events');
    Route::post('/events/{id}/update-slots', [\App\Http\Controllers\EventController::class, 'updateSlots'])->name('organizer.updateSlots');
});

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;

Route::get('/', [EventController::class, 'index'])->name('home');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::post('/events/{id}/review', [\App\Http\Controllers\EventReviewController::class, 'store'])->middleware('auth')->name('events.review');
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/faq', 'faq')->name('faq');

Route::middleware('guest.custom')->group(function() {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', [EventController::class, 'dashboard'])->name('dashboard');
    Route::post('/events/{id}/register', [EventController::class, 'registerForEvent'])->name('events.register');

    // Registration cancellation and waitlist
    Route::delete('/registrations/{id}/cancel', [\App\Http\Controllers\RegistrationController::class, 'cancel'])->name('registrations.cancel');
    Route::post('/events/{id}/waitlist', [\App\Http\Controllers\RegistrationController::class, 'joinWaitlist'])->name('events.waitlist');

    Route::post('/admin/events/{id}/approve', [EventController::class, 'approve']);
    Route::post('/admin/events/{id}/reject', [EventController::class, 'reject']);

    // Organizer update slots
    Route::post('/organizer/events/{id}/update-slots', [\App\Http\Controllers\EventController::class, 'updateSlots'])->name('organizer.updateSlots');

    Route::get('/gallery', [GalleryController::class,'index']);
    Route::post('/gallery/upload', [GalleryController::class,'upload']);
        Route::get('/gallery/upload', [GalleryController::class, 'showUploadForm'])->name('gallery.uploadForm');
        Route::post('/gallery/upload', [GalleryController::class, 'upload'])->name('gallery.upload');
    Route::post('/certificates/upload', [CertificateController::class,'upload']);
    Route::get('/my-certificates', [CertificateController::class,'myCertificates']);
    Route::post('/certificates/{id}/pay', [\App\Http\Controllers\CertificateController::class, 'payFee'])->name('certificates.pay');
    Route::get('/qr/{id}', [QRController::class,'generate']);
    Route::get('/qr-scan', [QRController::class,'scan']);
    Route::get('/reports/csv', [ReportController::class,'exportCSV']);
    Route::get('/reports/pdf', [\App\Http\Controllers\ReportController::class, 'exportPDF'])->name('reports.pdf');
    Route::get('/reports/excel', [\App\Http\Controllers\ReportController::class, 'exportExcel'])->name('reports.excel');
    Route::get('/notifications', [NotificationController::class,'index']);

    // Feedback routes
    Route::post('/events/{id}/feedback', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/events/{id}/feedback', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('feedback.index');

    // Profile routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [\App\Http\Controllers\ProfileController::class, 'changePassword'])->name('profile.password');

    // Favorites
    Route::post('/favorites/event/{id}', [\App\Http\Controllers\FavoriteController::class, 'addEvent'])->name('favorites.addEvent');
    Route::post('/favorites/media/{id}', [\App\Http\Controllers\FavoriteController::class, 'addMedia'])->name('favorites.addMedia');
    Route::get('/favorites', [\App\Http\Controllers\FavoriteController::class, 'myFavorites'])->name('favorites.index');
});
