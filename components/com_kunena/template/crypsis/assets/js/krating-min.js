jQuery(document).ready(function(c){var e=document.querySelector("#krating");(function d(){var f=c("#topic_id").val();if(c("#krating").length>0){c.ajax({dataType:"json",url:"index.php?option=com_kunena&view=topic&layout=getrate&format=raw",data:"topic_id="+f}).done(function(g){b(a(),g,f);}).fail(function(g){});}})();function a(){var f=document.createElement("div");f.innerHTML='<ul class="c-rating"></ul>';e.appendChild(f);return f;}function b(g,j,h){var l=g.querySelector(".c-rating");var i=j;var f=5;var m=function(n){c.ajax({dataType:"json",url:c("#krating_submit_url").val(),data:"starid="+n+"&topic_id="+h}).done(function(o){if(o.success){c('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><h4>Success</h4>'+Joomla.JText._(o.message)+"</div>").appendTo("#system-message-container");}else{c('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><h4>Warning!</h4>'+Joomla.JText._(o.message)+"</div>").appendTo("#system-message-container");}}).fail(function(o){c('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><h4>Warning!</h4>'+o+"</div>").appendTo("#system-message-container");});};var k=rating(l,i,f,m);}});