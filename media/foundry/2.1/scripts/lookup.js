(function(){var e=function(e){var t=this,n=function(){var t={using:[],inside:{},within:[],exclude:[],match:function(e){},depth:1},n=function(e,t){return typeof e=="string"||typeof e=="number"?e.toUpperCase().indexOf(t.toUpperCase())>=0:!1};e.lookup=function(r){typeof r=="string"&&(r={using:arguments[0],dataset:arguments[1]||{}}),r=e.extend({},t,r);if(e.isEmptyObject(r.inside))return{};typeof r.using=="string"&&(r.using=e.trim(r.using).split(" "));if(r.using.length<1)return r.inside;typeof r.within=="string"&&(r.within=e.trim(r.within).split(" "));var i=e.makeArray(e.extend(!0,{length:r.inside.length},r.inside)),s=[];return e.each(r.using,function(t,o){s=s.concat(e.grep(i,function(t){var i=!1;if(t[".added"])return;e.each(r.exclude,function(e,r){for(key in r)return i=n(t[key],r[key]),!i});if(i)return!1;if(r.within.length>0)e.each(r.within,function(e,r){return i=n(t[r],o),!i});else for(key in t){i=n(t[key],o);if(i)break}return i&&(t[".added"]=!0),i}))}),s}};n(),t.resolveWith(n)};dispatch("lookup").containing(e).to("Foundry/2.1 Modules")})();