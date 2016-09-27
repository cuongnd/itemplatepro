EasyBlog.module("responsive",function(e){var t=this;e.fn.responsive=function(){var t=this,n={elementWidth:function(){return e(t).outerWidth(!0)},conditions:e.makeArray(arguments)};e.responsive.process.call(t,n)},e.responsive=function(t,n){n.conditions=e.makeArray(n.conditions),e.responsive.process.call(e(t),n)},e.responsive.process=function(t){var n=this,r=t.conditions.length;e(window).resize(function(){e.responsive.sortConditions(t);var r;e.isFunction(t.elementWidth)?r=t.elementWidth():r=t.elementWidth,e.each(t.conditions,function(i,s){var o=e.responsive.properConditions(s),u=s.at;e.isFunction(s.at)?u=s.at():u=s.at;if(r<=u)return e.responsive.resetToDefault.call(n,t.conditions,i),e.responsive.resize.call(n,o),!1;e.responsive.deresize.call(n,o)})}).resize()},e.responsive.resize=function(t){var n=this;t.switchTo&&e.each(t.switchTo,function(e,t){n.addClass(t)}),t.alsoSwitch&&e.each(t.alsoSwitch,function(t,n){e(t).addClass(n)}),t.targetFunction&&t.targetFunction(),t.switchStylesheet&&e.each(t.switchStylesheet,function(t,n){var r=e('link[href$="'+n+'"]');r.length<1&&e("<link/>",{rel:"stylesheet",type:"text/css",href:n}).appendTo("head")})},e.responsive.deresize=function(t){var n=this;t.switchTo&&e.each(t.switchTo,function(e,t){n.removeClass(t)}),t.alsoSwitch&&e.each(t.alsoSwitch,function(t,n){e(t).removeClass(n)}),t.reverseFunction&&t.reverseFunction(),t.switchStylesheet&&e.each(t.switchStylesheet,function(t,n){e('link[href$="'+n+'"]').remove()})},e.responsive.resetToDefault=function(t,n){var r=this;e.each(t,function(t,i){if(n&&t==n)return!0;e.responsive.deresize.call(r,i)})},e.responsive.properConditions=function(t){var n={at:t.at,alsoSwitch:t.alsoSwitch,switchTo:e.makeArray(t.switchTo),switchStylesheet:e.makeArray(t.switchStylesheet),targetFunction:t.targetFunction,reverseFunction:t.reverseFunction};return n},e.responsive.sortConditions=function(t){var n=t.conditions.length;for(var r=0;r<n;r++)for(var i=r+1;i<n;i++){var s,o;e.isFunction(t.conditions[r].at)?s=t.conditions[r].at():s=t.conditions[r].at,e.isFunction(t.conditions[i].at)?o=t.conditions[i].at():o=t.conditions[i].at;if(s>o){var u=t.conditions[r];t.conditions[r]=t.conditions[i],t.conditions[i]=u}}},t.resolve()});