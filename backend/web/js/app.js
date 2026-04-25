/*
 * 
 * School Management 
 */

$(function() {
    "use strict";

    //Make the dashboard widgets sortable Using jquery UI
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header, .nav-tabs",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
    $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");
    
//    if(typeof $(".date-picker-txt") != "undefined"){
////        $('#userprofile-birthday, .date-picker-txt').datetimepicker({  minDate:new Date()});   
//        $('.date-picker-txt').click(function(){
//            $(".input-group-addon").trigger('click')
//        });
//    }

    // Fee Process form fee calculations.
    if(typeof( $('input[name="StudentFee[fee_month][]"]')) == "object"){
        var feeAmount =  $("#studentfee-fee_amount").val();
        var discountAmount =  $("#studentfee-discount_amount").val();
        $('input[name="StudentFee[fee_month][]"]').click(function(){ 
            if(feeAmount == 0) feeAmount =  $("#studentfee-fee_amount").val();
            if(discountAmount == 0) discountAmount =  $("#studentfee-discount_amount").val();
//            if($(this).is(':checked')){
                $("#studentfee-fee_amount").val($('input[name="StudentFee[fee_month][]"]:checked').length *feeAmount); 
                $("#studentfee-discount_amount").val($('input[name="StudentFee[fee_month][]"]:checked').length *discountAmount); 
                console.log( $('input[name="StudentFee[fee_month][]"]:checked').length * $("#studentfee-fee_amount").val() ) ;
//            }
            
        });
    }
    if( parseInt( $("#studentfee-status").val()) != 1) {$('.field-studentfee-receipt_amount').hide();}
    $("#studentfee-status").change( function(){ console.log(">>" + $(this).val() );

        if( $(this).val()  == 1 ){
            $('.field-studentfee-receipt_amount').show();
        }else{
            $('.field-studentfee-receipt_amount').hide();
        } 

     });
  var cdate = $.datepicker.formatDate('dd/mm/yy', new Date());
  
  if(typeof moment != "undefined") cdate = moment().format('DD-MMM-YYYY');
 $('#grid-print').on('click', function(){
     
     
//   $('table').attr('border','1');
   var grid = $(this).attr('data');
   
   var gridData = $.parseJSON(grid);
   
   var gridName = gridData.grid_name;
   var mainTitle = gridData.main_title;
   var logoImage = gridData.logo_image;
   var subTitle = gridData.sub_title;
   var subTitleFloat = gridData.sub_title_float;
   var selectedSection, monthSelected ;
   if( typeof($('.section_id')) !="undefined" && $('.section_id option:selected').text()!= "Section" && $('.section_id option:selected').text()!= ""){ 
        monthSelected = $('tr:nth-child(1) td:nth-child(10)').html();
        selectedSection = " of Class "+$('.section_id option:selected').text()+  ", Month: "+monthSelected;
      
        }else{selectedSection = "";}
   
   if($('.print_title_option').val()!= "" && $('.print_title_option').val()!= undefined )  subTitle = $('.print_title_option').val();
   var gridColToHide = gridData.hide_col.split("," );
   
   console.log( );
   
  $('.pagination').hide();  
  $('#'+gridName+'-filters').hide();
  $('.non-print').hide();
  $('.print-only').show();
//   $('table tr td:nth-child(9), th:nth-child(9)').hide()// gr

   $.each(gridColToHide, function(index, val){
       console.log("index"+index+ "value"+val)
       $('table tr td:nth-child('+val+'), th:nth-child('+val+')').hide()
   }) 
//   $('table tr td:nth-child(7), th:nth-child(7)').hide()

//   $('table tr td:nth-child(3), th:nth-child(3)').hide()
    if(gridData.hide_last != 0){
    $('table tr td:last-child').hide()
    $('table tr th:last-child').hide()
   }
   if(subTitleFloat == null || subTitleFloat == "")
       subTitleFloat = "float:right";

  var divToPrint=document.getElementById(gridName);

  var newWin=window.open('','Print-Window');
  
  

  newWin.document.open();
  var stylesheet = '<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">'
         +ifbootstrap(gridData)
         +'<style type="text/css" media="print"> body{font-family: Source Sans Pro,Helvetica Neue ,Helvetica,Arial,sans-serif;'
         +' } table, th, td{ font-size: 14px; border-collapse:collapse;          border: 1px solid black;        '
          +'text-align:left;        } a {text-decoration:none; color:black}  </style>';
// var divHead = '<div style="width:11in">'

 var divHead = '<div ">'
                +'<div style ="font-size:25px; font-weight:bold;text-align: center;" >'
   +'<img src="/img/'+logoImage+'.png" alt="LOGO"  width="60pt" align="center" style="padding:0 15px;" >'+mainTitle+' </div>';
//  divHead+='<h2>Student Admission List From 01st April 2017 to 15th April 2017<h2>';
  divHead+='<div style="'+subTitleFloat+'"><span style="text-align:right; float:'+subTitleFloat+'; font-size:22px;"><span>'+subTitle +" "+selectedSection
          +',</span> <span style="font-size:14px;">Date:'+cdate+'</span></span>'
            +'</div></div>';
  newWin.document.write('<html><head>'+stylesheet+'</head><body onload="window.print()">'+divHead+"<div style='float:left'>"+divToPrint.innerHTML+'</div></body></html>');

//  newWin.document.print();
  newWin.print();

  setTimeout(function(){newWin.close(); $('.pagination').show(); $('.non-print').show(); $('table tr td:last-child').show()
   $('table tr th:last-child').show();  $('#student-grid-filters').show();  },18500);
   })
   
   /* Exam Schedule */
   
    $(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
    });

    $(".dynamicform_wrapper_examschedule").on("afterInsert", function(e, item) {
        console.log("afterInsert");
//        console.log($('.container-items-examschedule').length)
        $('.date-picker-txt').each(function() {$(this).datetimepicker({ format:'YYYY-MM-DD'}) }); 
       // $('#examinationschedule-'+($('.item-examschedule').length-1)+'-start_at').val($('.item-examschedule').length)
    });

    $(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
        if (! confirm("Are you sure you want to delete this item?")) {
            return false;
        }
        return true;
    });

    $(".dynamicform_wrapper").on("afterDelete", function(e) {
        console.log("Deleted item!");
    });

    $(".dynamicform_wrapper").on("limitReached", function(e, item) {
        alert("Limit reached");
    });
    /** Examination Schedule suggestion*/
    var nextDate;
    $('.suggest_schedule').click(function(){
        if( typeof $('#suggestion_start-date').data('date') != "undefined"){
        $('.subject_selection input:checked').each(function(i,k) {
         //   console.log($(this).val() ); 
            
            // set date to load in suggestion
            var avlu = $(this).val(); 
            var nd ; nd = nextDate; 
            if(typeof nextDate == 'undefined' || nextDate == 0) 
                nd = $('#suggestion_start-date').data('date');
            if(i==0 ) nextDate = nd ; else nextDate = getNextDate(nd);
//            console.log(nd);
            
            
            $('.add-item-examschedule:first').click(); // add new 
            //console.log('add in process');
            $('#examinationschedule-'+($('.item-examschedule').length-1)+'-exam_id').val($('#suggestion_exam').val()) ;
            $('#examinationschedule-'+($('.item-examschedule').length-1)+'-class_id').val($('#suggestion_class').val()) ;
            $('#examinationschedule-'+($('.item-examschedule').length-1)+'-section_id').val($('#suggestion_section').val()) ;
            $('#examinationschedule-'+($('.item-examschedule').length-1)+'-subject_id').val(avlu );
            $('#examinationschedule-'+($('.item-examschedule').length-1)+'-day_of_week').val(nextDate) ;
            $('#examinationschedule-'+($('.item-examschedule').length-1)+'-total_marks').val('100');
            $('#examinationschedule-'+($('.item-examschedule').length-1)+'-min_marks').val('35');
//            $('#examinationschedule-'+($('.item-examschedule').length-1)+'-duration').val('2 Hours');
            $('#examinationschedule-'+($('.item-examschedule').length-1)+'-status').val(1);

         });
     
         if($('#examinationschedule-0-subject_id').val() =="" ) $('.remove-item-examschedule:first').click();
         if($('#__swap_days').is(':checked')) {swapSubjects(); }
         $('#suggestion_modal').modal('toggle');
         nextDate = 0 ;
        }else {
            alert('Start Date can not be blank');
            $('#suggestion_start-date').parent().addClass('has-error')
        }   
        
        if($('#__swap_days').is(':checked')) {swapSubjects(); }
    })
    
    $('.suggest_reset').click(function(){
        $('.remove-item-examschedule').each(function(){$(this).click(); })
         $('.add-item-examschedule:first').click();
         $('.remove-item-examschedule:first').click();
    })
    
    $('.swap_random').click(function (){
        swapSubjects();
    })
    
    $('.load_test_data').click(function(){
        $.each($('.form-group').find('input'), function(){
                if($(this).val() == ''){ console.log($(this).attr('id'))
                    $(this).val((Math.floor((Math.random() * 100) + 1))   )
                } ;
           })
    })
    
    if(typeof  $('#studentattendancereport-0-total_day_count')  == 'object'){
        $('#studentattendancereport-0-total_day_count').change(function(){
            $('.total_day_count').val($('#studentattendancereport-0-total_day_count').val() );
        })
        
        $('.present_day_count, .leave_day_count').change(function(){
           
           var row =  $(this).parents('.row');
           var present_day_count = row.find('.present_day_count');
           var total_days = row.find('.total_day_count');
           if(row.find('.leave_day_count').val() == "") row.find('.leave_day_count').val(0);
           var leave_days = row.find('.leave_day_count');
           console.log( ( total_days.val() -  present_day_count.val() ) );
           var daycount =  parseInt(present_day_count.val()) + parseInt(leave_days.val());
           
            row.find('.present_percentage').val( Math.ceil(( daycount / total_days.val()  )*100 )) ;
//            $('.present_day_count').val($('#studentattendancereport-0-total_day_count').val() );
        })
    }
    
    if(typeof $('.pagination') == 'object' && $('.pagination').is(':visible')){
    // get the value of the bottom of the #main element by adding the offset of that element plus its height, set it as a variable
        var mainbottom = $('.pagination').offset().top + $('.pagination').height();
        
//        console.log( ">>"+$('.pagination').height());

        if( $('.table-striped').length == 1 && $('.table-striped').find('tr').length > 30){

                    // on scroll, 
                    $(window).on('scroll',function(){

                        // we round here to reduce a little workload
                        var stop = Math.round($(window).scrollTop());

                        if (stop < mainbottom && !/Mobi/.test(navigator.userAgent) ) { // exmpt mobile browsers
                            $('.table-striped thead').addClass('stick-label');
                            $('.filters').hide();
                        } 
                        if(stop == 0) {
                            $('.table-striped thead').removeClass('stick-label');$('.filters').show();
                        }

                    });
                }
    }
    $('.Count').each(function () {
        var $this = $(this);
        var txt = $(this).text();
        jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
          duration: 5000,
          easing: 'swing',
          step: function () {
            $this.text(Math.ceil(this.Counter));
          },
          done: function(){
               $this.text(txt)
          }
        });
      });
      $('.btn-action').click(function(e){
          e.preventDefault();
         loadOtherDetails($(this)); 
      });
      $('#loader').hide();
      $(document).on('pjax:send', function() {
        $('.btn-lg').hide(); $('#loader').show();
       })
       $(document).on('pjax:complete', function() {
         $('.btn-lg').show();
        $('#loader').hide();
        if($('.print-now').length > 0){console.log('Going to print..');  window.open($('.print-now').attr('href') );}
       })
       
       /* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
        var prevScrollpos = window.pageYOffset;
        window.onscroll = function() {
          var currentScrollPos = window.pageYOffset;
          if (prevScrollpos > currentScrollPos) {
            $(".navbar").css("top" , "0");
          } else {
            $(".navbar").css("top" , "-50px");
          }
          prevScrollpos = currentScrollPos;
        }
        
        $('.student-checkbox').change(function(){
//            console.log($(this).attr('value'));
//            console.log($('.student-checkbox:checked').length  );
            $('.present-span').html($('.student-checkbox:checked').length );
            $('.absent-span').html($('.student-checkbox:not(:checked)').length );
            $(this).parent().addClass('text-danger bg-danger')
            if( $(this).is(':checked')) $(this).parent().removeClass('text-danger bg-danger')
        })
        
   /* end */
})

function getNextDate(date){
            var nd = new Date(date);
            var nextDate = new Date(nd.valueOf() + 1000*3600*24);
            
            if($('#__alternate_days').is(':checked'))
                nextDate = new Date(nextDate.valueOf() + 1000*3600*24);
            
//            console.log($.datepicker.formatDate('DD', nextDate) );
            if($.datepicker.formatDate('DD', nextDate) == 'Sunday' && $('#__not_sunday').is(':checked') )
                nextDate = new Date(nextDate.valueOf() + 1000*3600*24);
            
            if($.datepicker.formatDate('DD', nextDate) == 'Saturday'  && $('#__not_saturday').is(':checked') )
                nextDate = new Date(nextDate.valueOf() + 1000*3600*48);
            
            nextDate = $.datepicker.formatDate('yy-mm-dd', nextDate);
            return nextDate ;
}
var swapCount =0;
function swapSubjects(){ 
    var max= $('.item-examschedule').length-1;
    var subC;
    var subA = Math.floor((Math.random() * max) + 1);
    var subB = Math.floor((Math.random() * max) + 1);
    
    if(subB == subA) subB = Math.floor((Math.random() * max) + 1);
    if(swapCount >= 4 && swapCount%2 == 1){ subA = 0; swapCount=-5; }
    
    var temp = $('#examinationschedule-'+subA+'-subject_id').val();
    $('#examinationschedule-'+subA+'-subject_id').val($('#examinationschedule-'+subB+'-subject_id').val() );
    $('#examinationschedule-'+subB+'-subject_id').val( temp);//debugger
    console.log(subA+" "+subB);
//    if(max  > 5) {subC = Math.ceil((Math.random() * (max-4)) + 1);
//        var tempC = $('#examinationschedule-'+subA+'-subject_id').val();
//        $('#examinationschedule-'+subA+'-subject_id').val($('#examinationschedule-'+subC+'-subject_id').val() );
//        $('#examinationschedule-'+subC+'-subject_id').val( tempC);
//    }
    swapCount++; 
}

/**
 * Swap Math to Monday
 */
function swapToMonday() {
    // will declare and call soon 13 july 2017
}

function toggleColumn(colIndex){
    $('.table th:nth-child('+colIndex+'), td:nth-child('+colIndex+')').toggle();
}
$('.toggle_column').click(function(){
    toggleColumn( $(this).attr('data')  );
})

function loadOtherDetails(thisEelemet){
    
    var url = thisEelemet.attr("href"); 
    alert(url)
    $.ajax({
        url: url,
        dataType: 'json',
        success: function(res) {

            // get the ajax response data
            var data = res.body;

            // update modal content here
            // you may want to format data or 
            // update other modal elements here too
            $('.modal-body').text(data);

            // show modal
             $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));

        },
        error:function(request, status, error) {
            console.log("ajax call went wrong:" + request.responseText);
        }
    });

}

function createSearchResultLiContent(item){
	var updateVoucher; var returnData;
	if(item.fee_arrears > 0 ){
		updateVoucher="<a href='/fee-management/student-fee/update?id="+item.last_voucher_id+"' class='btn text-green btn-sm'>Update Voucher</a>";
		
	}else{
		updateVoucher="<a href='/fee-management/student-fee/view?id="+item.last_voucher_id+"' class='btn text-green btn-sm'>View Voucher</a>";
	}
	var viewBtn="<a href='/school-management/student/view?id="+item.id+"' class='btn text-green btn-sm	'>View Student</a>";
	if(item.object == 'student'){
        //ExaminationResultSearch
		var viewParentBtn="<a href='/user-management/user/view?id="+item.parent_id+"' class='btn text-green btn-sm	'>View Parent</a>";
		var viewSiblingBtn="<a href='/school-management/student/index?StudentSearch[parent_id]="+item.parent_id+"' class='btn text-green btn-sm	'>Siblings</a>";
        var viewResultsBtn="<a href='/school-management/examination-result?ExaminationResultSearch[student_id]="+item.id+"' class='text-green btn-sm	'>View Results</a>";
	}
	returnData = "<div class='row'><div class='col-lg-8'><a href='/school-management/student/view?id="+item.id+"'>"+item.label+"</a><br><span style=\"font-size: 12px;\">Class:"+item.section+",  Arrears: "+item.fee_arrears+", "+item.last_voucher_status+ "</span></div><div class='col-lg-4'>"+item.photo+"</div></div><div class='row'><div class='co-md-12'>"+updateVoucher+viewBtn+viewParentBtn+viewSiblingBtn+viewResultsBtn+"</div></div>"
	if(item.object == 'student_fee' ){
		var viewBtn="<a href='/school-management/student/view?id="+item.student_id+"' class='btn text-green btn-sm	'>View Student</a>";
		returnData = "<div class='row'><div class='col-lg-12'><a href='/school-management/student/view?id="+item.id+"'><b>Voucher:</b>"+item.label+"</a><br><span style=\"font-size: 12px;\">Class:"+item.section+",  Arrears: "+item.fee_arrears+", "+item.last_voucher_status+ " of "+item.total_amount+ " in "+item.fee_month+ "</span></div></div><div class='row'><div class='co-md-12'>"+updateVoucher+viewBtn+"</div></div>"
	}
	return returnData;	
}

function ifbootstrap(gridData){
    if(gridData.bootstrap_layout ==1)
        return  '<!-- Bootstrap 3.3.6 -->  <link href="/assets/46fe9aec/css/bootstrap.css?v=1549641543" rel="stylesheet">';
    
}