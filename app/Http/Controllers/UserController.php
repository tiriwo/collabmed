<?php

namespace App\Http\Controllers;

use App\Asset;
use App\BorrowList;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        if(Auth::user()->is_admin==1){
            return redirect('/manage/assets');
        }
        return view('user.index');
    }
    public function request(Request $request){
       $id=Auth::id();
       BorrowList::create([
          'user_id'=>$id,
          'asset_id'=>$request->id,
          'status'=>'pending'
       ]);
       Notification::create([
          'user_id'=>$id,
          'message'=>'You requested for asset: '.$request->name,
          'alert'=>'info'
       ]);
    }
    public function cancelRequest(Request $request){
        $id=Auth::id();
        $listItem = BorrowList::where('user_id',$id)->where('asset_id',$request->id)->first();
        $listItem->delete();
        Notification::create([
            'user_id'=>$id,
            'message'=>'You cancelled your request for asset: '.$request->name,
            'alert'=>'warning'
        ]);
    }
    public function getAssets(){
        $id=Auth::user()->id;
        $borrowedAssetsIds= BorrowList::where('status','pending')->where('user_id',$id)->pluck('asset_id');
        $availableAssets = Asset::where('user_id',null)->whereNotIn('id',$borrowedAssetsIds)->get()->toArray();
        $pending= Asset::whereIn('id',$borrowedAssetsIds)->get();
        $borrowedAssets  = Asset::where('user_id',Auth::id())->get();
        return response()->json(['available'=>$availableAssets,'pending'=>$pending,'borrowed'=>$borrowedAssets]);
    }
}
