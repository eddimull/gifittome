<?php namespace App\Extensions;


use App\CommunityAdmin;
use DB;
use App\Admin;
use Illuminate\Auth\Guard;
use Cookie;
use Session;

class AuthExtension extends Guard{

    public function admin(){
        $user = $this->user();
        $adminSearch = Admin::where('userID',$user->id)->first();
        $admin = false;
        if($adminSearch)
        {
        	$admin = true;
        }     	
        return $admin;
    }
    // public function communityAdmin()
    // {
    // 	$user= $this->user();
    // 	$communityAdminSearch = DB::table('CommunityAdmins')->join('Communities','Communities.ID','=','CommunityAdmins.CommunityID')->where('UserID','=',$user->ID)->get();
    // 	$communityAdmin = false;
    // 	if($communityAdminSearch)
    // 	{
    // 		$communityAdmin = $communityAdminSearch;
    // 	}
    // 	return $communityAdmin;
    // }


}