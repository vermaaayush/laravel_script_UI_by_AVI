
 <!-- // top navbar -->
           <?php 
                    $confiG = DB::table('configs')->where('id','1')->first();
                    $popupsN = DB::table('ba_pop_pages')->orderby('id','asc')->get();
                    
                ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Summary</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<style type="text/css">
	
.container{width: 100%;margin:auto;height:auto;padding: 5%;background-color: #f5f5f5;font-size:18px;}
p{font-size: 16px;}
td{padding-left: 1%;}

</style>
<body style="width: 45%;margin:auto">
 

	<div class="container">
	   
	      <div class="flex flex-wrap -mx-3">
	      	<div class="w-full md:w-1/2 px-3">
	      		<img src="https://ibank.firstallianzgroup.com/admin/uploads/{{$logo}}" width="60%">
	      	</div>
	      	<div class="col-md-2" style="text-align: right">
	      	
	      		
	      	</div>
	      	<div class="col-md-4" style="text-align: right">
	      		<p >{{$confiG->bank_address}}</p>
	      		
	      	</div>
	      </div>
	     
	      
	      <?php 

	   $user_info = DB::table('ba_account_holders')->where('user_id',$u_id)->first();  
	  
                     
                    
                ?>
	        
         
	      <div class="flex flex-wrap -mx-3">
	          
	         
	         <img style="margin-left:-5%;position: absolute;left:6%;top:120px;z-index: 1;" src="https://ibank.firstallianzgroup.com/online/uploads/Screenshot_2022-10-17_173937-removebg-preview.png" width="50px" height="100px">      
	        
	          
	      
	       
	       
	      	<div class="w-full md:w-1/2 px-3" style="text-align: left;">
	      		<p>{{$user_info->title}} {{$user_info->cust_name}} {{$user_info->sur_name}}<br>{{$user_info->cust_address}}</p>
	      		
	      		
	      	<img src="https://ibank.firstallianzgroup.com/online/uploads/barcode.png" width="50%">
	      	</div>
	      	<div class="w-full md:w-1/2 px-3" style="text-align: right;">
	      		<p><strong>Call us on: </strong> {{$confiG->bank_phone}}<br><strong>Email: </strong> {{$confiG->bank_email}}</p>
	      		<p><?php echo date("F j, Y") ?></p>
	      	
	      	</div>
	      </div>
         <br>
         <br>
         
	      <p><strong>Dear {{$user_info->title}} {{$user_info->cust_name}} {{$user_info->sur_name}}</strong></p>
	      <h5>Confirmation of your electronic funds transfer</h5>
	      <p>we've sent the following transfer from your account as requested.</p>
	      <br>
	    
 @foreach ($transaction_summary as $t_summary)
	      <table style="width:100%;padding: 1%;" border="1">
	             <?php 
                      $x = DB::table('ba_other_transfers')->where('user',$t_summary->user_id)->latest('id')->first();                               
                                           
                    $benefi_name = DB::table('ba_beneficiary')->where('id',$x->benefe)->first();
                    
                    
                     $footer_text = DB::table('ba_extras')->where('id','2')->first();
                    
                ?>

  <tbody>
    <tr>
      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" colspan="2">

      	<strong>From :</strong>
      	<p>{{$user_info->title}} {{$user_info->cust_name}} {{$user_info->sur_name}}</p>
 
      </td>
      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" colspan="2">

      	<strong>To :</strong>
      	<p>{{$benefi_name->beneficiary_name}}</p>
 
      </td>
    </tr>

    <tr>
      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" colspan="2">

      	<strong>Transaction Date :</strong>
      	<p>{{$t_summary->datetime}}</p>
 
      </td>
      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" colspan="2">

      	<strong>Transactions Reference :</strong>
      	<p>{{$t_summary->tran_id}}</p>
 
      </td>
    </tr>

    <tr>
      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" >

      	<strong>Currency :</strong>
      	<p>{{ $currency }}</p>
      	
 
      </td>
      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" >

      	<strong>Currency Value :</strong>
      	<p>{{$t_summary->amount}}</p>
      	
 
      </td>
      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">

      	<strong>Exchange Rate :</strong>
      	<p>1.00000000</p>
      	
 
      </td>
      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">

      <strong>Exchange Value :</strong>
      	<p>{{$t_summary->amount}}</p>
 
      </td>
    </tr>

    <tr>
      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" colspan="2">

      	<strong>Destination Bank :</strong>
      	<p>{{$benefi_name->beneficiary_bank_name}}</p>
 
      </td>
      <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" colspan="2">

      	<strong>Destination Account :</strong>
      	<p>{{$benefi_name->beneficiary_account}}</p>
 
      </td>
     
    </tr>
   
    

     
    
   
  </tbody>
</table>

<br>
<strong>Transaction detail:</strong>
<p>{{$user_info->title}} {{$user_info->cust_name}} {{$user_info->sur_name}}</p>
<p>{{$t_summary->tran_id}}</p>
<br>
 <?php 
                   $charges = DB::table('ba_transactions')->where('tran_id',$t_summary->tran_id)->where('type','charges')->first();
                   
                   
                   $total=$t_summary->amount+$charges->amount;
                   
                ?>
<div class="flex flex-wrap -mx-3">
	<div class="col-md-5">
		<br>	<br>
<strong>CHARGES:</strong>
<p>SWIFT EXPENSES USD {{$charges->amount}}</p>


<br>

           
	</div>
	<div class="col-md-7">
	 <p style="border:1px solid black;padding:3%"><strong>Debited Amount: </strong>{{ $currency }} {{$t_summary->amount}}</p>
	 <p style="border:1px solid black;padding:3%"><strong>Charges: </strong>{{ $currency }} {{$charges->amount}}</p>
	 <p style="border:1px solid black;padding:3%"><strong>Total Amount Debited: </strong>{{ $currency }} {{$total}}</p>
		
		
	
	</div>
</div>


<div class="flex flex-wrap -mx-3">
	<div class="col-md-5">
	 <p style="border:1px solid black;padding:3%"><strong>Charge Option: </strong>SHARED</p>
           
	</div>
	<div class="col-md-7">

	</div>
</div>		
@endforeach

<br>
<br>

<div style="font-size:10px">{!! $footer_text->loan_landing_text !!}</div>


</div>


</body>
</html>
<script type="text/javascript">
      window.onload = function() { window.print(); }
 </script>
<!-- Page Content  -->
