<?php

namespace App\Http\Controllers;

use App\Asset;
use App\BorrowList;
use App\Notification;
use App\User;
use Illuminate\Http\Request;

class ManageController extends Controller
{
    public function index(){
        return view('admin.borrow-list');
    }
    public function getList(){
        $list= BorrowList::query()->orderBy('created_at')->get();
        $users= User::whereIn('id',$list->pluck('user_id'))->get();
        $assets= Asset::whereIn('id',$list->pluck('asset_id'))->get();
        return response()->json(['list'=>$list,'users'=>$users,'assets'=>$assets]);
    }
    public function allowAsset(Request $request){
        $asset= Asset::find($request->get('asset_id'));
        $asset->fill(['user_id'=>$request->get('user_id')])->save();
        Notification::create([
           'user_id'=>$request->get('user_id'),
           'message'=>'Your request for asset: '.$asset->name.' was assigned to you.' ,
            'alert'=>'success'
        ]);
        BorrowList::find($request->id)->delete();
    }
    public function denyAsset(Request $request){
        $asset= Asset::find($request->get('asset_id'));
        Notification::create([
            'user_id'=>$request->get('user_id'),
            'message'=>'Your request for '.$asset->name.' was declined: '.$request->reason  ,
            'alert'=>'danger'
        ]);
        BorrowList::find($request->id)->delete();
    }

    public function viewReport(){
        $availableAssets= Asset::where('user_id',null)->get();
        $leasedAssets= Asset::where('user_id','!==',null)->get();
        return view('admin.report',compact('availableAssets','leasedAssets'));
    }
}
