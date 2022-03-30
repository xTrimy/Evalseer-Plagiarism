<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BadgeController extends Controller
{
    public function view() {
        $user = Auth::user();

        $badges = $users = DB::table('badges_criterias')->distinct()->get();

        $badges_opened = DB::table('user_badges')
                        ->where('user_id',$user->id)
                        ->select('user_badges.badge_id')
                        ->get();

        $badgec = count($badges);
        $badgeo = count($badges_opened);
        $badges_closed = $badgec - $badgeo;

        $rank = DB::table('user_ranks')
                ->where('user_id',$user->id)
                ->select('user_ranks.*')
                ->latest('id')
                ->first();
                
        $rank_name = DB::table('ranks')
                ->where('id',$rank->badge_id)
                ->select('ranks.name')
                ->first();

        return view('badges',['user'=>$user,'rank_name'=>$rank_name,'badges_closed'=>$badges_closed,'badges_opened'=>$badgeo]);
    }
}
