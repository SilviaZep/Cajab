function handler1() {
  //e.preventDefault();
  $("#menu").animate({ 'margin-left' : 0 }, 300);
  $(".main-cont").animate({ 'margin-left' : 256 }, 300);
  $("#boton-menu").addClass("open");
  $(".velo").show();
  //  $("#boton-menu").one('click', handler2);
}
function handler2() {
  //e.preventDefault();
  $("#menu").animate({ 'marginLeft' : -256 }, 300);
  $(".main-cont").animate({ 'marginLeft' : 0 }, 300);
  $("#boton-menu").removeClass("open");
  $(".velo").hide();
  //  $("#boton-menu").one('click', handler1);
}
function ajustaMenu() {
  $("#menu").removeAttr("style");
  $(".main-cont").removeAttr("style");
  $("#boton-menu").removeClass();
  $("#boton-menu").unbind('click');
  $(".velo").unbind('click');
  $(".velo").hide();
  if ($(window).width() <= 360) {
    $("#menu").hide();
    $("#boton-menu").on('click', function (e) {
      e.preventDefault();
      $("#menu").slideToggle();
      $(this).toggleClass("open");
    });
  } else if (($(window).width() > 360)) { //&& ($(window).width() < 992)
	$("#boton-menu").on('click', handler1);
    $(".velo").on('click', handler2);
  }
}



if (!String.prototype.trim) {
  String.prototype.trim=function(){return this.replace(/^\s+|\s+$/g, '');};
  String.prototype.ltrim=function(){return this.replace(/^\s+/,'');};
  String.prototype.rtrim=function(){return this.replace(/\s+$/,'');};
  String.prototype.fulltrim=function(){return this.replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g,'').replace(/\s+/g,' ');};
}

function alertOK(title, alertMessage, parent){
  var panelTemp = $("<div>").addClass('panel panel-default success-panel').append('<div class="panel-heading">'+
        '<h3 class="panel-title"><span class="fa fa-check-circle"></span> <span>'+title+'</span><span class="pull-right fa fa-times alert-close"></span></h3>'+
        '</div>'+
        '<div class="panel-body js-okloc-msg">'+alertMessage+'</div>');
  $(parent).before(panelTemp);
  panelTemp.slideDown();
  panelTemp.find('.alert-close').on('click',function(){panelTemp.fadeOut({ queue: false }).slideUp();});
  setTimeout(function(){
    panelTemp.fadeOut({ queue: false }).slideUp(function(){
      panelTemp.remove();
    });
  },5000);
}
function alertError(title, alertMessage, parent){
  var panelTemp = '<div class="panel panel-default error-panel">'+
      '<div class="panel-heading">'+
      '<h3 class="panel-title"><span class="fa fa-times-circle"></span> <span>'+title+'</span><span class="pull-right fa fa-times alert-close"></span></h3>'+
      '</div>'+
      '<div class="panel-body">'+alertMessage+'</div>'+
      '</div>';
  panelTemp = $(panelTemp);
  $(parent).before(panelTemp);
  panelTemp.slideDown();
  panelTemp.find('.alert-close').on('click',function(){panelTemp.fadeOut({ queue: false }).slideUp();});
  setTimeout(function(){
    panelTemp.fadeOut({ queue: false }).slideUp(function(){
      panelTemp.remove();
    });
  },5000);
}

function countLimit(textArea,target,limit){
  var valid = [8,16,17,18,33,34,35,36,37,38,39,40,46];
  var nMsg = $(textArea);
  var cLeft = $(target);
  cLeft.text((limit - parseInt(nMsg.val().length) ) + " characters remain")
  nMsg.on("paste contextmenu",function(e){e.preventDefault();});
  nMsg.on("keydown",function(k){ 
    if($(this).val().length >= limit){
      if($.inArray(k.which,valid)<0)
        k.preventDefault();
    }
  }).on("keyup",function(k){
    cLeft.text((limit - parseInt($(this).val().length)) + " characters remain");
  });
  $( document ).ajaxStop(function(){
    cLeft.text((limit - parseInt(nMsg.val().length)) + " characters remain");
  });
}

jQuery(function ($) {
   //New button to hide left menu 
   $("#boton-hide-menu").on('click', function (e) {
	  //Hide left menu
	  handler2();
	  $(".main-cont").css("width", "100%");
	  $("#boton-menu").show();
	  $("#boton-hide-menu").hide();
	  
	  resizeVideo();
  });
	
	
  $(".dtpicker").datepicker({ dateFormat: "mm/dd/yy", changeMonth: true, changeYear: true });
  $(".dtpicker-today").datepicker({ dateFormat: "mm/dd/yy", changeMonth: true, changeYear: true, maxDate: "+0D" });
  $(".dtpicker").next(".input-group-addon").on('click',function(){ $(this).prev(".dtpicker").focus(); }).css("cursor","pointer");
  $(".dtpicker-today").next(".input-group-addon").on('click',function(){ $(this).prev(".dtpicker-today").focus(); }).css("cursor","pointer");
  //$("[type=text]").attr("maxlength","50");
  $(document).on('keydown',".num-field",function(e){
    k = e.keyCode;
    if((e.shiftKey&&k!=9)&&(e.shiftKey&&k!=35)&&(e.shiftKey&&k!=36)&&(e.shiftKey&&k!=37)&&(e.shiftKey&&k!=39)){e.preventDefault();}
    if(k==46||k==8||k==9||k==35||k==36||k==37||k==38||k==39||k==40){
    }else{if(k<95){if(k<48||k>57){e.preventDefault();}}else{if(k<96||k>105){e.preventDefault();}}}
  });//end numeric keydown
  if($(".new-message").length>0)
  countLimit(".new-message [name=message]", ".char-left", 400);

  $(".btns-filters").closest(".titulo").on('click',function(e){
    e.preventDefault();
    t = $(this);
    t.parent().find(".btns-filters a").toggle();
    t.closest(".busqueda").find(".campos").slideToggle();
  });
  $(".assignment").on('click','.course-row',function(){ $(this).next("tr").find(".detail").slideToggle(); });
  ajustaMenu();
  // Componente multiseleccion
  $(".checkAll [type=checkbox]").on('change',function(){
    chks = $(this).parent().prev(".multisel-chk").find("[type=checkbox]");
    if($(this).is(":checked"))
      chks.prop("checked",true);
    else
      chks.removeAttr('checked');
  });


  $(window).on('resize', ajustaMenu);
  
  	$(".js-team-btn").on('click', function (e) {
		e.preventDefault();
		console.log($("#team-status-loaded").val());
  		//Lets load team status if this is the first click
  		if($("#team-status-loaded").val() == 0){
  			loadTeamStatus();
  		}else{
  	  		$(".team").slideToggle();
  	  		$(this).toggleClass("open");
  		}
  	});

  $(".progress").each(function(){
    var p = $(this).find(".progress-bar");
    var n = $(this).parent().find(".progress-info");
    var t = 0;
    p.each(function(){
      var th = $(this).data("p");
      if (typeof th == 'number' )
        t += parseInt(th);
    });
    p.each(function(){
      th = $(this);
      thp = th.data("p");
      if (thp !== undefined){
        wp = (parseInt(thp)*100/t)+"%";
        th.css("width",t ? wp : thp );
        if ((n !== undefined) && (Number(thp) > 0 )){
          n.append("<div style=\"width:"+wp+";\">"+thp+"</div>");
        }
      }
    });
  });
  $(".custom-input-file input").on("change",function(){ $(this).parent().prev("[type=text]").val($(this).val());});
});



//do this once the DOM's available...
$(function(){

    // this line will add an event handler to the selected inputs, both
    // current and future, whenever they are clicked...
    // this is delegation at work, and you can use any containing element
    // you like - I just used the "body" tag for convenience...
    $("body").on("click", ".dtpicker_new", function(){

        // as an added bonus, if you are afraid of attaching the "datepicker"
        // multiple times, you can check for the "hasDatepicker" class...
        if (!$(this).hasClass("hasDatepicker"))
        {
            $(this).datepicker({ dateFormat: "mm/dd/yy", changeMonth: true, changeYear: true });
            $(this).datepicker("show");
        }
    });
});


