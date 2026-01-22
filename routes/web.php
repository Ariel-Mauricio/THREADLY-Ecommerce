<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PromotionController as AdminPromotionController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ExportController as AdminExportController;
use Illuminate\Support\Facades\Route;

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/{slug}', [ProductController::class, 'show'])->name('products.show');

// Product Reviews (public read)
Route::get('/productos/{product}/reviews', [ReviewController::class, 'productReviews'])->name('products.reviews');

// Static Pages
Route::get('/terminos-y-condiciones', [PageController::class, 'terms'])->name('terms');
Route::get('/politica-de-privacidad', [PageController::class, 'privacy'])->name('privacy');
Route::get('/sobre-nosotros', [PageController::class, 'about'])->name('about');
Route::get('/contacto', [PageController::class, 'contact'])->name('contact');
Route::post('/contacto', [PageController::class, 'sendContact'])->name('contact.send');

// Cart Routes (API - with CSRF protection and rate limiting)
Route::middleware(['throttle:cart'])->group(function () {
    Route::get('/cart', [CartController::class, 'get'])->name('cart.get');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

// Payment Routes
Route::get('/payment/card/{order}', [PaymentController::class, 'payphone'])->name('payment.payphone');
Route::post('/payment/card/{order}', [PaymentController::class, 'payphoneProcess'])->name('payment.payphone.process');
Route::get('/payment/callback', [PaymentController::class, 'payphoneCallback'])->name('payment.payphone.callback');
Route::get('/payment/cancel', [PaymentController::class, 'payphoneCancel'])->name('payment.payphone.cancel');
Route::post('/payment/webhook', [PaymentController::class, 'payphoneWebhook'])->name('payment.payphone.webhook')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Order Success (public access to view order success)
Route::get('/pedido/{order}/exito', function ($order) {
    $order = \App\Models\Order::with('items.product')->findOrFail($order);
    return view('orders.success', compact('order'));
})->name('orders.success');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Password Reset
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // User Profile
    Route::prefix('perfil')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/editar', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/editar', [ProfileController::class, 'update'])->name('update');
        Route::get('/cambiar-password', [ProfileController::class, 'showChangePassword'])->name('password');
        Route::put('/cambiar-password', [ProfileController::class, 'changePassword'])->name('password.update');
        
        // Addresses
        Route::get('/direcciones', [ProfileController::class, 'addresses'])->name('addresses');
        Route::post('/direcciones', [ProfileController::class, 'storeAddress'])->name('addresses.store');
        Route::put('/direcciones/{address}', [ProfileController::class, 'updateAddress'])->name('addresses.update');
        Route::delete('/direcciones/{address}', [ProfileController::class, 'deleteAddress'])->name('addresses.destroy');
        Route::post('/direcciones/{address}/default', [ProfileController::class, 'setDefaultAddress'])->name('addresses.default');
    });
    
    // Wishlist
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/toggle/{product}', [WishlistController::class, 'toggle'])->name('toggle');
        Route::post('/add/{product}', [WishlistController::class, 'add'])->name('add');
        Route::delete('/remove/{product}', [WishlistController::class, 'remove'])->name('remove');
        Route::delete('/clear', [WishlistController::class, 'clear'])->name('clear');
        Route::get('/count', [WishlistController::class, 'count'])->name('count');
        Route::post('/move-to-cart/{product}', [WishlistController::class, 'moveToCart'])->name('move-to-cart');
    });
    
    // Reviews
    Route::post('/reviews/{product}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // User Orders
    Route::get('/mis-pedidos', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $orders = $user->orders()->with('items.product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    })->name('orders.index');
    
    Route::get('/mis-pedidos/{order}', function ($order) {
        $order = \App\Models\Order::where('user_id', Auth::id())->with('items.product')->findOrFail($order);
        return view('orders.show', compact('order'));
    })->name('orders.show');
    
    Route::put('/mis-pedidos/{order}/cancelar', function ($order) {
        $order = \App\Models\Order::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'processing'])
            ->findOrFail($order);
        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'Pedido cancelado correctamente');
    })->name('orders.cancel');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Dashboard Charts (AJAX)
    Route::get('/charts/sales', [DashboardController::class, 'salesChartData'])->name('charts.sales');
    Route::get('/charts/orders-status', [DashboardController::class, 'ordersStatusChartData'])->name('charts.orders-status');
    Route::get('/charts/categories', [DashboardController::class, 'categoriesChartData'])->name('charts.categories');
    
    // Products
    Route::resource('products', AdminProductController::class);
    
    // Categories
    Route::resource('categories', AdminCategoryController::class)->except(['show', 'edit']);
    
    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

    // Promotions
    Route::get('promotions', [AdminPromotionController::class, 'index'])->name('promotions.index');
    Route::post('promotions/bulk-apply', [AdminPromotionController::class, 'bulkApply'])->name('promotions.bulk-apply');
    Route::post('promotions/bulk-remove', [AdminPromotionController::class, 'bulkRemove'])->name('promotions.bulk-remove');
    Route::delete('promotions/{product}', [AdminPromotionController::class, 'removePromotion'])->name('promotions.remove');
    
    // Users Management
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
    Route::post('users/{user}/restore', [AdminUserController::class, 'restore'])->name('users.restore');
    Route::post('users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
    
    // Exports
    Route::prefix('export')->name('exports.')->group(function () {
        Route::get('/orders', [AdminExportController::class, 'orders'])->name('orders');
        Route::get('/products', [AdminExportController::class, 'products'])->name('products');
        Route::get('/users', [AdminExportController::class, 'users'])->name('users');
        Route::get('/sales-report', [AdminExportController::class, 'salesReport'])->name('sales-report');
    });
    
    // Reviews Management
    Route::get('reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::post('reviews/{review}/approve', [\App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('reviews/{review}/reject', [\App\Http\Controllers\Admin\ReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('reviews/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Activity Logs
    Route::get('activity', [\App\Http\Controllers\Admin\ActivityController::class, 'index'])->name('activity.index');
    Route::delete('activity/clear', [\App\Http\Controllers\Admin\ActivityController::class, 'clear'])->name('activity.clear');
    
    // Reports
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
});
