!function(t){var o={};function e(i){if(o[i])return o[i].exports;var n=o[i]={i:i,l:!1,exports:{}};return t[i].call(n.exports,n,n.exports,e),n.l=!0,n.exports}e.m=t,e.c=o,e.d=function(t,o,i){e.o(t,o)||Object.defineProperty(t,o,{enumerable:!0,get:i})},e.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},e.t=function(t,o){if(1&o&&(t=e(t)),8&o)return t;if(4&o&&"object"==typeof t&&t&&t.__esModule)return t;var i=Object.create(null);if(e.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:t}),2&o&&"string"!=typeof t)for(var n in t)e.d(i,n,function(o){return t[o]}.bind(null,n));return i},e.n=function(t){var o=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(o,"a",o),o},e.o=function(t,o){return Object.prototype.hasOwnProperty.call(t,o)},e.p="/",e(e.s=2)}([,,function(t,o,e){t.exports=e(3)},function(t,o){function e(){}function i(){var t=$("#SURVIVED").val(),o=$(".death");switch(t){case"0":o.show();break;default:o.hide()}}function n(){$("#advanced-loot-view, #middot-1").removeClass("d-inline-block").hide(),$(".adv").slideDown(115)}function a(){$("#timer_auto, #stop_stopwatch, .sw_status").hide(),$("#timer_manual, #start_sw, #stopwatch_enabled").show()}function s(){$("#timer_auto, #stop_stopwatch").show(),$("#timer_manual, #start_sw").hide(),$("#start_sw").hide(),window.date1=new Date,$("#timer_auto small").html("PREPARING..."),$.ajax({method:"POST",url:window.start_stopwatch_url,data:{_token:window.csrf_token}}).done((function(t){c(),window.stopwatch_interval=setInterval(c,1500)})).fail((function(t){alert(t.error)}))}function r(){"undefined"!=typeof Notification?Notification.requestPermission().then((function(t){"denied"===t?Toastify({text:"❌ You did not allow notifications.",duration:3e3,close:!0,gravity:"top",position:"center"}).showToast():(Toastify({text:"✔ Browser notifications turned on.",duration:3e3,close:!0,gravity:"top",position:"center"}).showToast(),$("#browser-notifications").hide())})):Toastify({text:"Sorry, your browser does not support this. Please update to the latest Chrome or Firefox",duration:3e3,close:!0,gravity:"top",position:"center"}).showToast()}function c(){$.ajax({method:"GET",url:window.check_status_url,data:{_token:window.csrf_token}}).done((function(t){$("#timer_auto small").html(t.status);var o=Math.floor(t.seconds/60),e=t.seconds%60;$("#timer_auto p").html((o<10?"0":"")+o+":"+(e<10?"0":"")+e),$("#run_length_minute").val(o),$("#run_length_second").val(e),$(".sw_status").hide(),$("."+t.infodiv).show(),"error"===t.infodiv?(d(),$("#start_sw").hide()):"finished"===t.infodiv&&clearInterval(window.stopwatch_interval),window.previous_state!==t.infodiv&&(window.previous_state=t.infodiv,function(t,o){if("undefined"!=typeof Notification)if("granted"===Notification.permission){var e=new Notification("Abyss Tracker Stopwatch",{body:t,icon:o});e.onclick=function(){e.close(),window.parent.focus()}}else Toastify({text:t,close:!0,avatar:o,gravity:"top",position:"right"}).showToast();else Toastify({text:t,close:!0,avatar:o,gravity:"top",position:"right"}).showToast()}(t.toast,t.msg_icon))}))}function d(){a(),$("#start_sw").show();try{clearInterval(window.stopwatch_interval)}catch(t){}}window.previous_state="starting",$((function(){i(),$("#TIER").change(e),$("#SURVIVED").change(i),$("#advanced-loot-view").click(n),a(),$("#stop_stopwatch").click(d),$("#start_sw").click(s),$("form").submit((function(t){})),$(".sw_status").hide(),$("#stopwatch_enabled").show(),$("#browser-notifications-enable").click(r),$("#vessel").select2({theme:"bootstrap",width:"100%",ajax:{url:window.fit_newrun_select},templateResult:function(t){return void 0!==t.id?$('<div class="row"><div class="col-md-3">'+(t.SHIP_ID>0?'<img src="https://imageserver.eveonline.com/Type/'+t.SHIP_ID+'_32.png" alt="" class="tinyicon rounded-circle mr-1" style="border: 1px solid #fff">':"")+t.SHIP_NAME+'</div><div class="col-md-3">'+t.SHIP_CLASS+'</div><div class="col-md-5"><span class="">'+t.FIT_NAME+"</span></div>"):$('<div class="row"><div class="col-md-12"><span class="font-weight-bold text-uppercase">'+t.text+'</span></div><div class="col-md-3 text-italic">Ship name</div>\n<div class="col-md-3 text-italic">Ship class</div>\n<div class="col-md-5 text-italic">Fit name</div></div>')}}).maximizeSelect2Height(),$("#LOOT_DETAILED").change((function(){$("#loot_value").html("..."),$.ajax({method:"POST",url:window.loot_detailed_url,data:{_token:window.csrf_token,LOOT_DETAILED:$("#LOOT_DETAILED").val()}}).done((function(t){console.log(t),sum=JSON.parse(t),$("#loot_value").html(sum.formatted)}))})),"undefined"!=typeof Notification?"granted"===Notification.permission&&$("#browser-notifications").hide():$("#browser-notifications").hide(),window.start_stopwatch_&&s(),window.advanced_open&&$("#advanced-loot-view").click()}))}]);