$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

function ajaxSubmit(button,form,secondForm,callback)
{

  $("#"+button).click(function(e){
    var user_id = '';
     var dataPass='';
     //alert($("#"+form).length)
    var dataPass=$('#'+form).serialize()+"&"+form+"=1";
    console.log(dataPass)
    if(secondForm && secondForm!='')
    {
      dataPass=dataPass+"&"+$("#"+secondForm).serialize();
    }
    if(user_id!='')
    dataPass+="&user_id="+user_id
    e.preventDefault();
    $.ajax({
      url:url+"online-open-account",
      method:'POST',
      data: dataPass,
      success:function(response) {
        if(response.insertResult){

        } else {

        }
        if(response.user_id)
        user_id=response.user_id;
      },
      error:function(error) {
        var errors='';
        console.log(error.responseJSON)
        if (error.responseJSON)
        {
          console.log(error.responseJSON.errors)
          $.each(error.responseJSON.errors,function(i,v){
          v.forEach(data=>{
             errors+="<div class='alert alert-danger'>"+data+"</div>"
            })

          });
          $("#open-error .modal-body").html(errors)
          $('#open-error').modal('show')
          $(".btn-dark.previous.action-button-previous:visible").trigger('click')
        }
      }
    });
  });
}

ajaxSubmit("aoc_fs_two","ao_fs_two",'')
ajaxSubmit("aoc_fs_three","ao_fs_three","ao_fs_two")
ajaxSubmit("aoc_fs_four","ao_fs_four",'')
ajaxSubmit("aoc_fs_five","ao_fs_five","")
ajaxSubmit("aoc_fs_six","ao_fs_six","")
ajaxSubmit("aoc_fs_seven","ao_fs_seven","")
ajaxSubmit("aoc_fs_eight","ao_fs_eight","")
ajaxSubmit("aoc_fs_nine","ao_fs_nine","")
ajaxSubmit("aoc_fs_ten","ao_fs_ten","")
ajaxSubmit("aoc_fs_eleven","ao_fs_eleven","")
ajaxSubmit("aoc_fs_twelve","ao_fs_twelve","")
ajaxSubmit("aoc_fs_thirteen","ao_fs_thirteen","")
ajaxSubmit("aoc_fs_fourteen","ao_fs_fourteen","")
ajaxSubmit("aoc_fs_fifteen","ao_fs_fifteen","")


/**
  * Internet banking option
  * ib - internet banking
  * fs - fieldset
  * i_fs_<fieldset> - fieldset id
  * ib_fs_<fieldset> - form id for corresponding fieldset
  * ibc_fs_<fieldset> - continue button id for corresponding fieldset
  */

function ajaxSubmitInternet(button, form)
{
  $("#"+button).click(function(e) {
    var user_id = '';
    var dataPass = '';
    var dataPass=$('#'+form).serialize()+"&"+form+"=1";
    console.log(dataPass)

    e.preventDefault();
    $.ajax({
      url:url+"new-account-steps",
      method:'POST',
      data: dataPass,
      success:function(response) {
        if(response.insertResult){

        } else {

        }
      },
      error:function(error){
        console.log(error.responseJSON)
      }
    });
  });
}

ajaxSubmitInternet("ibc_fs_three", "form-wizard1")


/**
  * Recover account pin
  * r - recover
  * rp - recover pin
  * fs - fieldset
  * r_fs_<fieldset> - fieldset id
  * rp_fs_<fieldset> - form id for corresponding fieldset
  * rpc_fs_<fieldset> - continue button id for corresponding fieldset
  */

 function ajaxSubmitRecoverPin(button, form, secondForm, callback)
 {

  $("#"+button).click(function(e){
    var dataPass='';
    //alert($("#"+form).length)
    var dataPass=$('#'+form).serialize()+"&"+form+"=1";
    console.log(dataPass)
    if(secondForm && secondForm!='')
    {
      dataPass=dataPass+"&"+$("#"+secondForm).serialize();
    }
    e.preventDefault();
    $.ajax({
      url:url+"retrieve-account-pin",
      method:'POST',
      data: dataPass,
      success:function(response) {
        if(response){

        } else {

        }
      },
      error:function(error){
        console.log(error)
      }
    });
  });
 }

 ajaxSubmitRecoverPin("rpc_fs_one","rp_fs_one",'')
 ajaxSubmit("rpc_fs_two","rp_fs_two","rp_fs_two")