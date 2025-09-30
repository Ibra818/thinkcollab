<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\LessonVideoController;
use App\Http\Controllers\VideoPresentationController;
use App\Http\Controllers\FeedVideoController;
use App\Http\Controllers\ProgressionController;
use App\Http\Controllers\FavoriVideoController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\FormationObjectiveController;
use App\Http\Controllers\FormationSectionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\FeedVideoCommentController;
use App\Http\Controllers\CollaborationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMessageController;
use App\Models\{User,};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Routes publiques
Route::get('/categories', [CategorieController::class, 'index']);
Route::get('/categories/{categorie}', [CategorieController::class, 'show']);
Route::get('/formations', [FormationController::class, 'index']);
Route::get('/formations/{formation}', [FormationController::class, 'show']);
Route::get('/feed-videos', [FeedVideoController::class, 'index']);
Route::get('/feed-videos/{feedVideo}', [FeedVideoController::class, 'show']);
Route::get('/feed-videos-page-data', [FeedVideoController::class, 'getPageData']);

// Authentication routes (no auth required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'apiLogin']) -> name('apiLogin');
Route::get('/logout', [AuthController::class, 'apiLogout'])->middleware('auth:sanctum');
Route::post('/userRole', function(Request $request){

        // $request -> validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8',
        //     'password_confirmation' => 'required|string|same:password',
        //     'profile' => 'required|string|in:apprenant, formateur, admin, superadmin',
        // ]);
        
        if($request -> password == $request -> password_confirmation){
                
                $user = User::create([
                    'name' => $request -> name,
                    'email' => $request -> email,
                    'password' => Hash::make($request->password),
                    'role' => $request -> profile,
                ]);
            }
        // 
        return response() -> json([ 'redirect' => route('home'), 'user' => $user]);
    });

// Password reset routes (TODO: implement)
Route::post('/password/reset', function() {
    return response()->json(['message' => 'Password reset functionality not yet implemented'], 501);
});

// User account management routes (auth required)
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user/change-to-formateur', [AuthController::class, 'changeToFormateur']);
    Route::delete('/user/delete-account', [AuthController::class, 'deleteAccount']);
});

// Public payment routes (no auth required)
Route::get('/payment-methods', [PaymentController::class, 'getPaymentMethods']);

// Webhook pour les paiements (sans authentification)
Route::post('/purchases/webhook', [PurchaseController::class, 'webhook']);

// Routes protégées par authentification
Route::middleware('auth:sanctum')->group(function () {
    
    // Categories (admin/formateur seulement)
    Route::post('/categories', [CategorieController::class, 'store']);
    Route::put('/categories/{categorie}', [CategorieController::class, 'update']);
    Route::delete('/categories/{categorie}', [CategorieController::class, 'destroy']);
    
    // Formations
    Route::post('/formations', [FormationController::class, 'store']);
    Route::put('/formations/{formation}', [FormationController::class, 'update']);
    Route::delete('/formations/{formation}', [FormationController::class, 'destroy']);
    Route::get('/my-formations', [FormationController::class, 'myFormations']);
    Route::post('/formations/{formation}/publish', [FormationController::class, 'publish']);
    Route::post('/formations/{formation}/unpublish', [FormationController::class, 'unpublish']);
    
    // Formation Objectives
    Route::get('/formations/{formation}/objectives', [FormationObjectiveController::class, 'index']);
    Route::post('/formations/{formation}/objectives', [FormationObjectiveController::class, 'store']);
    Route::put('/formation-objectives/{objective}', [FormationObjectiveController::class, 'update']);
    Route::delete('/formation-objectives/{objective}', [FormationObjectiveController::class, 'destroy']);
    
    // Formation Sections
    Route::get('/formations/{formation}/sections', [FormationSectionController::class, 'index']);
    Route::post('/formations/{formation}/sections', [FormationSectionController::class, 'store']);
    Route::put('/formation-sections/{section}', [FormationSectionController::class, 'update']);
    Route::delete('/formation-sections/{section}', [FormationSectionController::class, 'destroy']);
    Route::post('/formations/{formation}/sections/reorder', [FormationSectionController::class, 'reorder']);
    
    // Lesson Videos
    Route::get('/formations/{formation}/videos', [LessonVideoController::class, 'index']);
    Route::post('/formations/{formation}/videos', [LessonVideoController::class, 'store']);
    Route::get('/lesson-videos/{lessonVideo}', [LessonVideoController::class, 'show']);
    Route::put('/lesson-videos/{lessonVideo}', [LessonVideoController::class, 'update']);
    Route::delete('/lesson-videos/{lessonVideo}', [LessonVideoController::class, 'destroy']);
    Route::post('/formations/{formation}/videos/reorder', [LessonVideoController::class, 'reorder']);
    
    // Video Presentations
    Route::post('/formations/{formation}/video-presentation', [VideoPresentationController::class, 'store']);
    Route::get('/video-presentations/{videoPresentation}', [VideoPresentationController::class, 'show']);
    Route::put('/video-presentations/{videoPresentation}', [VideoPresentationController::class, 'update']);
    Route::delete('/video-presentations/{videoPresentation}', [VideoPresentationController::class, 'destroy']);
    
    // Feed Videos
    Route::post('/feed-videos', [FeedVideoController::class, 'store']);
    Route::put('/feed-videos/{feedVideo}', [FeedVideoController::class, 'update']);
    Route::delete('/feed-videos/{feedVideo}', [FeedVideoController::class, 'destroy']);
    Route::get('/my-feed-videos', [FeedVideoController::class, 'myFeedVideos']);
    
    // Feed Video Engagement
    Route::post('/feed-videos/{feedVideo}/like', [FeedVideoController::class, 'like']);
    Route::post('/feed-videos/{feedVideo}/view', [FeedVideoController::class, 'recordView']);
    Route::post('/feed-videos/{feedVideo}/share', [FeedVideoController::class, 'recordShare']);

    // Feed Video Comments
    Route::get('/feed-videos/{feedVideo}/comments', [FeedVideoCommentController::class, 'index']);
    Route::post('/feed-videos/{feedVideo}/comments', [FeedVideoCommentController::class, 'store']);
    Route::post('/comments/{comment}/like', [FeedVideoCommentController::class, 'like']);
    
    // Purchases
    Route::get('/purchases', [PurchaseController::class, 'index']);
    Route::post('/purchases', [PurchaseController::class, 'store']);
    Route::get('/purchases/{purchase}', [PurchaseController::class, 'show']);
    Route::put('/purchases/{purchase}/status', [PurchaseController::class, 'updateStatus']);
    
    // Inscriptions
    Route::get('/inscriptions', [InscriptionController::class, 'index']);
    Route::get('/inscriptions/{inscription}', [InscriptionController::class, 'show']);
    Route::put('/inscriptions/{inscription}/status', [InscriptionController::class, 'updateStatus']);
    Route::get('/inscriptions/{inscription}/progress', [InscriptionController::class, 'getProgress']);
    
    // Progressions
    Route::post('/progressions', [ProgressionController::class, 'store']);
    Route::get('/progressions/{progression}', [ProgressionController::class, 'show']);
    Route::put('/progressions/{progression}', [ProgressionController::class, 'update']);
    Route::get('/inscriptions/{inscription}/progressions', [ProgressionController::class, 'getByInscription']);
    
    // Favoris
    Route::get('/favoris', [FavoriVideoController::class, 'index']);
    Route::post('/favoris', [FavoriVideoController::class, 'store']);
    Route::delete('/favoris/{favoriVideo}', [FavoriVideoController::class, 'destroy']);
    Route::post('/favoris/toggle', [FavoriVideoController::class, 'toggle']);
    
    // Messages
    Route::get('/messages', [MessageController::class, 'index']);
    Route::post('/messages', [MessageController::class, 'store']);
    Route::get('/messages/{message}', [MessageController::class, 'show']);
    Route::post('/messages/{message}/read', [MessageController::class, 'markAsRead']);
    Route::get('/conversations/{user}', [MessageController::class, 'getConversation']);
    Route::get('/messages/unread/count', [MessageController::class, 'getUnreadCount']);
    
    // Follows
    Route::post('/users/{user}/follow', [FollowController::class, 'follow']);
    Route::delete('/users/{user}/unfollow', [FollowController::class, 'unfollow']);
    Route::get('/users/{user}/followers', [FollowController::class, 'followers']);
    Route::get('/users/{user}/followings', [FollowController::class, 'followings']);
    Route::get('/my-followers', [FollowController::class, 'myFollowers']);
    Route::get('/my-followings', [FollowController::class, 'myFollowings']);
    Route::get('/users/{user}/is-following', [FollowController::class, 'isFollowing']);
    
    // User Profile
    Route::get('/profile', [UserProfileController::class, 'myProfile']);
    Route::post('/profile', [UserProfileController::class, 'update']);
    Route::get('/users/{user}/profile', [UserProfileController::class, 'show']);
    Route::get('/profile/enrolled-courses', [UserProfileController::class, 'getEnrolledCourses']);
    Route::get('/profile/favorite-videos', [UserProfileController::class, 'getFavoriteVideos']);
    Route::get('/profile/recent-courses', [UserProfileController::class, 'getRecentCourses']);
    Route::get('/profile/page-data', [UserProfileController::class, 'getProfilePageData']);
    Route::post('/profile/resend-verification', [UserProfileController::class, 'resendEmailVerification']);
    
    // Payment routes (auth required)
    Route::post('/payments/initialize', [PaymentController::class, 'initializePayment']);
    Route::get('/payments/{transactionId}/status', [PaymentController::class, 'checkPaymentStatus']);
    Route::post('/payments/{transactionId}/cancel', [PaymentController::class, 'cancelPayment']);
    Route::get('/payments/transactions', [PaymentController::class, 'getUserTransactions']);
    
    // Admin payment statistics
    Route::get('/payments/statistics', [PaymentController::class, 'getPaymentStatistics'])->middleware('can:viewAny,App\\Models\\Purchase');

    // Collaborations (projects as formations)
    Route::get('/collaborations', [CollaborationController::class, 'index']);
    Route::post('/formations/{formation}/collaborations/invite', [CollaborationController::class, 'invite']);
    Route::post('/collaborations/{collaboration}/accept', [CollaborationController::class, 'accept']);
    Route::post('/collaborations/{collaboration}/decline', [CollaborationController::class, 'decline']);
    Route::delete('/collaborations/{collaboration}', [CollaborationController::class, 'revoke']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']); // optional
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead']);
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead']);

    // Groups & Group Messages
    Route::get('/groups', [GroupController::class, 'index']);
    Route::post('/groups', [GroupController::class, 'store']);
    Route::get('/groups/{group}/members', [GroupController::class, 'members']);
    Route::post('/groups/{group}/members', [GroupController::class, 'addMember']);
    Route::delete('/groups/{group}/members/{user}', [GroupController::class, 'removeMember']);
    Route::get('/groups/{group}/messages', [GroupMessageController::class, 'index']);
    Route::post('/groups/{group}/messages', [GroupMessageController::class, 'store']);
});

// Payment callbacks (no auth required)
Route::get('/payments/{transactionId}/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payments/{transactionId}/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');

// Payment webhooks (no auth required)
Route::post('/webhooks/touchpoint', [PaymentController::class, 'touchPointWebhook'])->name('payment.webhook.touchpoint');
