<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BadgeController extends Controller
{
    public function view() {
        $user = Auth::user();

        $badges = $users = DB::table('badges_criterias')->distinct()->get();

        $badgeo = 0;
        $count_badge = 0;

        $badges_opened = DB::table('user_badges')
                        ->where('user_id',$user->id)
                        ->select('user_badges.badge_id')
                        ->get();

        for ($i=1;$i<=6;$i++) {
            $bdg = DB::table('user_badges')
                        ->where('user_id',$user->id)
                        ->where('badge_id',$i)
                        ->select('user_badges.badge_id')
                        ->get();
            $count_badge = count($bdg);

            if($count_badge >= 5) {
                $badgeo++;
            }
        }

        $user = Auth::user();
        $all_badges = Badge::with(['user_badges'=>function($query) use($user){
            return $query->where('user_id',$user->id);
        }])->get();
     
        $badgec = count($badges);

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

        return view('badges',['user'=>$user,'all_badges'=>$all_badges,'rank_name'=>$rank_name,'badges_closed'=>$badges_closed,'badges_opened'=>$badgeo]);
    }
}
