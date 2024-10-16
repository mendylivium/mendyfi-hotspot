<?php

use Illuminate\Support\Carbon;
use App\Livewire\Client\Payout;
use App\Livewire\Admin\Settings;
use App\Livewire\Client\Balance;
// use App\Livewire\Client\Purchase\CreateOrder;
use App\Livewire\Client\Auth\Login;
use App\Livewire\Client\Sales\Sales;
use App\Http\Controllers\TestControl;
use App\Livewire\Admin\User\UserList;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\PaymentSetting;
use App\Livewire\Client\Auth\Register;
use App\Http\Controllers\Api\SalesGraph;
use App\Livewire\Admin\User\UserLicense;
use App\Livewire\Client\Profile\Profile;
use App\Http\Controllers\Api\VouchersInfo;
use App\Http\Controllers\Radius\Accounting;
use App\Livewire\Client\Dashboard\Dashboard;
use App\Livewire\Client\Profile\EditProfile;
use App\Http\Controllers\Api\XenditController;
use App\Livewire\Client\Hotspot\Vouchers\Used;
use App\Livewire\Client\Profile\CreateProfile;
use App\Http\Controllers\Radius\Authentication;
use App\Livewire\Client\Settings\Configuration;
use App\Livewire\Client\Hotspot\Vouchers\Active;
use App\Livewire\Client\Hotspot\Vouchers\Generate;
use App\Livewire\Client\Hotspot\Vouchers\Generated;
use App\Http\Controllers\Api\XenditDisburseController;
use App\Livewire\Admin\AddDomain;
use App\Livewire\AdminDashboard;
use App\Livewire\Client\Hotspot\Template\EditTemplate;
use App\Livewire\Client\Hotspot\Template\CreateTemplate;
use App\Livewire\Client\Hotspot\Template\GeneratedTemplate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['web', 'universal']], function () {
    Route::get('/login', function () {
        return redirect()->route('admin.auth.login');
    });
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
            Route::get('login', Login::class)->name('admin.auth.login');
        });

        Route::group(['middleware' => 'auth'],function(){
            Route::get('dashboard', AdminDashboard::class)->name('admin.dashboard');

            Route::get('logout',function(){
                auth()->logout();
                return redirect()->route('admin.auth.login');
            })->name('admin.logout');
        });
        Route::group(['prefix' => 'domain'], function(){
            Route::get('add',AddDomain::class)->name('admin.domain.add');
        });
    });
});

Route::get('/', function () {
    return redirect()->route('client.auth.login');
});

Route::get('/lic', function(){
    return response()->json([
        'result' => 'success',
        'license_code' => 'LGBYDETAFKTPGZ0RNRGDFWe75867eb9f417c6f9bda33781702f3ee38a3b79ad59415b7dbc6386e5cd7c789',
        'message' => request()->get('activate_key')
    ]);
});

Route::get('/host', function(){

    dd(Carbon::now()->subMonth()->month);
});

Route::match(['GET','POST'],'cashless/{publicToken}/{profileId}/{dnsUrl}',[XenditController::class,'createCashlessPayment'])->name('cashless.profile');
Route::match(['GET','POST'],'cashless/{publicToken}/{profileId}/{dnsUrl}/{resellerId}',[XenditController::class,'createCashlessPayment']);

Route::group(['prefix' => 'api'],function(){
    Route::group(['prefix' => 'radius'],function(){
        Route::match(['GET','POST'],'auth',[Authentication::class,'gateway']);
        Route::match(['GET','POST'],'accounting',[Accounting::class,'gateway']);
    });


    Route::match(['GET','POST'],'vouchers',[VouchersInfo::class,'print'])->name('api.vouchers.print');
    Route::match(['GET','POST'],'sales',[SalesGraph::class,'index'])->name('api.sales');
    Route::match(['GET','POST'],'profiles/{apiPublic}',[VouchersInfo::class,'getAllProfiles'])->name('api.profiles.all');
    Route::match(['GET','POST'],'profiles/{apiPublic}/{resellerId}',[VouchersInfo::class,'getResellerProfiles'])->name('api.profiles.reseller');
});


Route::group([ 'prefix' => 'client'],function(){

    Route::group(['prefix' => 'auth', 'middleware' => 'guest'],function(){
        Route::get('login',Login::class)->name('client.auth.login');
        // Route::get('register',Register::class)->name('client.auth.register');
    });

    Route::group(['middleware' => 'auth'],function(){

        Route::get('logout',function(){
            auth()->logout();
            return redirect()->route('client.auth.login');
        })->name('logout');

        Route::get('dashboard',Dashboard::class)->name('client.dashboard');
        Route::group(['prefix' => 'hotspot'],function(){
            //Vouchers
            Route::group(['prefix' => 'vouchers'],function(){
                Route::get('list',Generated::class)->name('client.vouchers.list');
                Route::get('used',Used::class)->name('client.vouchers.used');
                Route::get('active',Active::class)->name('client.vouchers.active');
                Route::get('generate',Generate::class)->name('client.voucher.generate');

                Route::get('print',[VouchersInfo::class,'template'])->name('client.voucher.print');

                Route::get('templates',GeneratedTemplate::class)->name('client.voucher.template');
                Route::get('create-template',CreateTemplate::class)->name('client.voucher.template.create');
                Route::get('edit-template-{id}',EditTemplate::class)->name('client.voucher.template.edit');

                Route::group(['prefix' => 'profile'],function(){
                    Route::get('list',Profile::class)->name('client.vouchers.profiles');
                    Route::get('create',CreateProfile::class)->name('client.vouchers.profile.create');
                    Route::get('edit-{id}',EditProfile::class)->name('client.vouchers.profile.edit');
                    Route::get('bind-policy-{id}',App\Livewire\Client\Profile\BindPolicy::class)->name('client.vouchers.profile.bind-policy');
                });
            });

            Route::group(['prefix' => 'reseller'], function(){
                Route::get('list',App\Livewire\Client\Reseller\ResellerList::class)->name('client.reseller.list');
                Route::get('add',App\Livewire\Client\Reseller\AddReseller::class)->name('client.reseller.add');
                Route::get('edit/{id}',App\Livewire\Client\Reseller\EditReseller::class)->name('client.reseller.edit');
            });

            Route::get('config', Configuration::class)->name('client.config');
            Route::get('sales', Sales::class)->name('client.sales');
        });

        Route::group(['prefix' => 'fair_use_policy'], function(){
            Route::get('list', App\Livewire\Client\FairUsePolicy\FupList::class)->name('client.fairuse.list');
            Route::get('add', App\Livewire\Client\FairUsePolicy\AddFup::class)->name('client.fairuse.add');
            Route::get('edit-{id}', App\Livewire\Client\FairUsePolicy\EditFup::class)->name('client.fairuse.edit');
        });

    });

});
