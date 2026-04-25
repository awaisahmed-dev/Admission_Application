/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    if(typeof ($("#ex13c").slider) != "undefined"){
	$("#ex13c").slider({ id: "slider_du", min: 1, max: 30, range: true, value: [0, 1200000] });
//		$('#slide').click(function(){
//			$('.slide').slideToggle();
//		});
		$("#ex12c").slider({ id: "slider_pr", min: 100, max: 1200000, range: true, value: [0, 1200000] });
//		$('#slide').click(function(){
//			$('.slide').slideToggle();
//		});
    }
    if(typeof ($('#userprofile-birthday').click) != "undefined" || typeof $(".date-picker-txt") != "undefined"){
//        $('#userprofile-birthday, .date-picker-txt').datetimepicker({  minDate:new Date()});   
        $('#userprofile-birthday').click(function(){
            $(".input-group-addon").trigger('click')
        });
    }
    /*
     * Tour Booking
     */
    $('#booking_from select').change(function(){
        console.log($(this).val());
        var parentPrice = $("#tour-price").val();
        var parentCurrency = $("#tour-currency").val();
        var adult = parseInt($("#booking-adults").val()); 
        var children = parseInt($("#booking-children").val()); 
        var totalTourPrice = parentPrice*adult;
        if(children > 0) totalTourPrice+= parentPrice*children;
        
        if(totalTourPrice > 0)
            $("#total_price").html(parentCurrency+" "+ totalTourPrice);
        else $("#total_price").html("0.00");
    })
    
    $('body').on('beforeSubmit', 'form#_booking_form', function () {
     var form = $(this);
     // return false if form still have some validation errors
     if (form.find('.has-error').length) {
          return false;
     }
     // submit form
     $('.progress').show();
     $('.booking-action').hide();
     $.ajax({
          url: form.attr('action'),
          type: 'post',
          data: form.serialize(),
          success: function (response) {
              $('.progress').hide();
              var responseData = (response);
              console.log(">>"+typeof (responseData.success));
              if(typeof (responseData.success) != "undefined"){
                    if(responseData.success == 1){
                        $('.progress-bar').addClass('progress-bar-success');
                        window.open(responseData.data.nextUrl,'_self');
                    }else{
                        $('.booking-action').show();
                        $(".booking-error").html(responseData.error['error-message']);

                    }
            }else{
                        $(".booking-error").html("Sorry, error in processing. Please try later.");
                
            }  
               // do something with response
          },
          error:function(){
               $('.progress').hide();
              $(".booking-error").html("Sorry, error in processing. Please try later.");
              $('.booking-action').show();
          }
     });
     return false;
});
    
    /*
     * 
     * Tour Booking End
     */
/*
 * Newsletter subscription 
 */    
var takenError = 1;
$("#form-newslettersubscription").submit(function(e){
     e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $("#form-newslettersubscription");
                if($(form).find('.has-error').length) {
                        return false;
                }
                
                $.ajax({
                        url: form.attr('action'),
                        type: 'post',
                        data: form.serialize(),
                        success: function(data) {
                            console.log(data);
                            dataArray = $.parseJSON(data)
                            if(dataArray.status == "success"){
                            $('#newsletter-form').html('<div class="well alert alert-success">'+
                                    'Thanks for our newsletter subscription.</div>');
                            $('.error').hide();
                            takenError = 0;
                            }else {
                                if(takenError != 0){
                                    console.log(takenError);
                                    takenError = 0;
                                    console.log(dataArray.message.email[0]);
                                    $('#newsletter-form').parents('div:first').append('<div class="error well alert alert-danger">'+
                                        dataArray.message.email[0]+'</div>');
                                    console.log(takenError);
                                }
                                
                            }
                                
                                // do something ...
                        }
                });
                return false;
               
        });
        
});        