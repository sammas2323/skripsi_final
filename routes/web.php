<?php

use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RentOrderController;
use App\Http\Controllers\VerificationController;


Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'check_status'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('/rent-orders/bulk-delete', [RentOrderController::class, 'bulkDelete'])->name('rent-orders.bulkDelete');
});

Route::get('/login', function () {
    return view('auth.login',);
})->name('login');

Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register',[AuthController::class, 'register']);

Route::get('/auth-google-redirect', [AuthController::class, 'google_redirect']);
Route::get('/auth-google-callback', [AuthController::class, 'google_callback']);

Route::group(['middleware' => ['auth', 'check_role:customer']], function(){
    Route::get('/verify', [VerificationController::class, 'index']);
    Route::post('/verify', [VerificationController::class, 'store']);
    Route::get('/verify/{unique_id}', [VerificationController::class, 'show']);
    Route::put('/verify/{unique_id}', [VerificationController::class, 'update']);
});

Route::get('/about', function () {
    return view('about',['title'=>'Tentang',]);
})->name('about'); // Beri nama route

Route::middleware(['auth', 'check_role:admin'])->group(function () { 
    Route::get('/rents/create', [RentController::class, 'create'])->name('rents.create');
    Route::post('/rents', [RentController::class, 'store'])->name('rents.store');
    Route::delete('/rents/bulk-delete', [RentController::class, 'bulkDelete'])->name('rents.bulkDelete');
});

Route::get('/rents', [RentController::class, 'index'])->name('rents.index');


Route::get('/rents/{slug}', function($slug){
    $rent = Rent::where('slug', $slug)->firstOrFail();
    return view('rent', ['title' => 'Detail Kontrakan', 'rent' => $rent]);
})->middleware('auth')->name('rents.show'); // Beri nama route

Route::middleware(['auth'])->group(function () {
    Route::get('/rent-orders/create', [RentOrderController::class, 'create'])->name('rent-orders.create');
    Route::post('/rent-orders', [RentOrderController::class, 'store'])->name('rent-orders.store');
    Route::get('/rent-orders/{id}', [RentOrderController::class, 'show'])->name('rent-orders.show');
    Route::get('/rent-orders/{id}/add-to-calendar', [RentOrderController::class, 'addToCalendar'])->name('rent-orders.addToCalendar');
});

Route::post('/midtrans/callback', [MidtransController::class, 'callback']);

Route::get('/rent-orders/{id}/success', [RentOrderController::class, 'success'])->name('rent-orders.success');


Route::get('/rent/pending', function () {
    return view('rent-orders.pending', ['title' => 'Pembayaran Tertunda']);
});

Route::get('/rent/error', function () {
    return view('rent-orders.error', ['title' => 'Pembayaran Gagal']);
});

Route::get('/test-route', function () {
    return 'Route aktif';
});

Route::middleware('auth')->group(function () {

    // Arahkan user ke Google untuk autentikasi OAuth
   Route::get('/google-calendar/oauth', function (Request $request) {
    $client = new \Google_Client();
    $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
    $client->addScope('https://www.googleapis.com/auth/calendar');
    $client->setRedirectUri(url('/google-calendar/oauth-callback'));
    $client->setAccessType('offline');
    $client->setPrompt('consent');

    // Simpan user ID dan redirect tujuan
    session([
        'google_oauth_user_id' => Auth::id(),
        'google_oauth_redirect_to' => $request->query('redirect_to', route('dashboard'))
    ]);

    return redirect($client->createAuthUrl());
    })->name('google.oauth');

    // Callback dari Google setelah user menyetujui akses
    Route::get('/google-calendar/oauth-callback', function (Request $request) {
    $client = new \Google_Client();
    $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
    $client->setRedirectUri(url('/google-calendar/oauth-callback'));
    $client->setAccessType('offline');
    $client->setPrompt('consent');

    if ($request->has('code')) {
        $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));
        // dd($token);

        // Coba autentikasi ulang user berdasarkan session
        if (!Auth::check()) {
            Auth::loginUsingId(session('user_id_for_oauth')); // sebagai fallback
        }

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('dashboard')->with('error', 'Gagal menyimpan token. Pengguna tidak ditemukan.');
        }

        $user->google_access_token = $token['access_token'] ?? null;
        $user->google_refresh_token = $token['refresh_token'] ?? $user->google_refresh_token; // jaga-jaga tidak dikirim ulang
        $user->google_token_expires = now()->addSeconds($token['expires_in'] ?? 3600);
        $user->save();

        $redirectTo = session()->pull('google_oauth_redirect_to', route('dashboard'));
        return redirect($redirectTo)->with('success', 'Google Calendar berhasil dihubungkan.');
    }

    return redirect()->route('dashboard')->with('error', 'Tidak ada kode otorisasi dari Google.');
    })->name('google.callback');


});


