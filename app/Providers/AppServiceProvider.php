<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\View;
use Validator;
use Hash;

use App\BorrowLog;
use App\Borrow_detail;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require base_path() . '/app/Helpers/frontend.php';

        Validator::extend('passcheck', function ($attribute, $value, $parameters) {
            return Hash::check($value, $parameters[0]);
        });

        View()->composer('layouts.notification', function ($view) {
            $get_notif = BorrowLog::with('details')
                ->where('user_id', Auth::user()->id)
                ->where('is_returned', 0)
                ->where('id', 8)
                ->get();

            $notification['count'] = $get_notif->count();
            $notification['data'] = [];
            foreach ($get_notif as $key => $notif) {
                $notification['data'][$key]['nomor_peminjaman'] = $notif->nomor_peminjaman;
                $notification['data'][$key]['buku'] = [];
                $notification['data'][$key]['keterangan'] = 'Terlambat '.$notif->keterlambatan.' hari';
                foreach ($notif->details as $i => $detail) {
                    $notification['data'][$key]['buku'][$i]['title'] = $detail->book->title;
                }
            }
            // dd($notification);
            $view->with('notification', $notification);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
