<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class CmsSection extends Controller
{
	public function __construct() {
	    $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
	}
	
	public function telexStamp(){
	    return view('cms/telex-stamp');
	}
	
	public function telexStampSave(Request $request){
	    $destinationPath = 'exasset/uploads/extra';
        $file = $request->file('image');
        if(!empty($file) && !empty($path = $file->getRealPath()) && !empty($image = $file->getClientOriginalName())) {
            $ext = $file->getClientOriginalExtension();
		    $type = $file->getMimeType();
		    $name = md5(microtime(true)).'.'.$ext;
            $file->move($destinationPath,$name);
            
            $data = [
    	        'telex_stamp'     => $name
    	    ];
    	    DB::table('ba_extra_asset')->where('id','1')->update($data);
        }
        
        flash('Stamp Changed')->success();
    	return redirect()->intended('telex-stamp');
	}
	
	public function profileStatus($id){
	    $data['user'] = DB::table('ba_account_holders')->where('id',$id)->first();
	    return view('cms/profile-status-message',$data);
	}
    
    public function pop_pages() {
        $list = DB::select('select * from ba_pop_pages');
    	return view('cms/pop_pages', ['list'=>$list]);
	}
	
	public function loanLandingPage() {
        $data['extra'] = DB::table('ba_extras')->where('id',"1")->first();
    	return view('cms/loan-landing-page', $data);
	}
	
	public function tranferFooter() {
        $data['extra'] = DB::table('ba_extras')->where('id',"2")->first();
    	return view('cms/tranfer-footer', $data);
	}
	
	public function tranferFooterSave(Request $req){
	    $data = [
	        'loan_landing_text'     => $req->content
	    ];
	    DB::table('ba_extras')->where('id','2')->update($data);
	    
	    flash('Content Saved')->success();
    	return redirect()->intended('transfer-footer');
	}
	
	public function loanLandingPageSave(Request $req){
	    $data = [
	        'loan_landing_text'     => $req->content
	    ];
	    DB::table('ba_extras')->where('id','1')->update($data);
	    
	    flash('Content Saved')->success();
    	return redirect()->intended('loan-landing-cms');
	}
	
	public function profileStatusUpdate(Request $req){
	    $data = [
	        'status_message'     => $req->message
	    ];
	    DB::table('ba_account_holders')->where('id',$req->main)->update($data);
	    
	    flash('Profile status has been updated.')->success();
    	return redirect()->intended('view-customers');
	}
	
	public function pop_pages_save(Request $req){
	    $data = [
	        'title'     => $req->title,
	        'content'    => $req->content
	    ];
	    DB::table('ba_pop_pages')->insert($data);
	    
	    flash('Popup added successfully!')->success();
    	return redirect()->intended('pop_pages');
	}
	
	public function pop_pages_delete($id){
	    DB::table('ba_pop_pages')->where('id',$id)->delete();
	    
	    flash('Popup added deleted!')->success();
    	return redirect()->intended('pop_pages');
	}
	
	public function pop_pages_update(Request $req){
	    $data = [
	        'title'     => $req->title,
	        'content'    => $req->content
	    ];
	    DB::table('ba_pop_pages')->where('id',$req->id)->update($data);
	    
	    flash('Popup update successfully!')->success();
    	return redirect()->intended('pop_pages');
	}
}