<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class Branch extends Controller
{
	public function __construct() {
	    $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
	}

    public function index() {
    	$branches = DB::select('select * from bank_details');
    	return view('branches', ['branches'=>$branches]);
    }

    public function addBranch() {
    	return view('add-branch');
    }

    public function insertBranch(Request $request) {
        $available_type_id = 'both';
    	$branch_name = $request->input('branch_name');
    	$branch_code = $request->input('branch_code');
    	$ifsc_code = $request->input('ifsc_code');
    	$branch_add = $request->input('branch_add');
    	if(!empty($branch_name) && !empty($branch_code) && !empty($ifsc_code) && !empty($branch_add)) {
    		DB::insert('insert into bank_details (branch_name,branch_code,ifsc_code,branch_add,available_type_id) values(?,?,?,?,?)',[$branch_name,$branch_code,$ifsc_code,$branch_add,$available_type_id]);
    		flash('Branch added successfully!')->success();
    		return redirect()->intended('branches');
    	}
        else {
        	flash('Please fill all the required fields')->error();
    		return redirect()->intended('login');
        }
    }

    public function editBranch(Request $request, $id) {
    	$branch = DB::select('select * from bank_details WHERE id = ?',[$id]);
    	return view('edit-branch', ['branch'=>$branch]);
    }

    public function updateBranch(Request $request) {
    	$id = $request->input('id');
    	$branch_name = $request->input('branch_name');
    	$branch_code = $request->input('branch_code');
    	$ifsc_code = $request->input('ifsc_code');
    	$branch_add = $request->input('branch_add');
    	if(!empty($id) && !empty($branch_name) && !empty($branch_code) && !empty($ifsc_code) && !empty($branch_add)) {
    		DB::insert('update bank_details SET branch_name = ?, branch_code = ?, ifsc_code = ?, branch_add = ? where id = ?',[$branch_name,$branch_code,$ifsc_code,$branch_add,$id]);
    		flash('Branch updated successfully!')->success();
    		return redirect()->intended('branches');
    	}
        else {
        	flash('Please fill all the required fields')->error();
    		return redirect()->intended('edit-branch/' . $id);
        }
    }

    public function deleteBranch(Request $request, $id) {
        $account = DB::table('ba_user_accounts')->where('bank',$id)->count();
        if($account > 0) {
            flash('Branch could not deleted as it is associated with customer accounts')->error();
            return redirect()->intended('branches');
        }
        DB::table('bank_details')->where('id',$id)->delete();
    	flash('Branch deleted successfully')->success();
		return redirect()->intended('branches');
    }
}
