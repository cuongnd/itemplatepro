//huong dan su dung

/*

 $('.view_items_default').view_items_default();



 view_items_default=$('.view_items_default').data('view_items_default');

 console.log(view_items_default);

 */



// jQuery Plugin for SprFlat admin view_items_default

// Control options and basic function of view_items_default

// version 1.0, 28.02.2013

// by SuggeElson www.suggeelson.com



(function($) {



    // here we go!

    $.view_items_default = function(element, options) {



        // plugin's default options

        var defaults = {
            enable_check_params:false
            //main color scheme for view_items_default

            //be sure to be same as colors on main.css or custom-variables.less




        }



        // current instance of the object

        var plugin = this;



        // this will hold the merged default, and user-provided options

        plugin.settings = {}



        var $element = $(element), // reference to the jQuery version of DOM element

            element = element;    // reference to the actual DOM element



        // the "constructor" method that gets called when the object is created



        plugin.init = function() {

            plugin.settings = $.extend({}, defaults, options);
            var enable_check_params=plugin.settings.enable_check_params;
            if(enable_check_params) {
                var option_click = {

                    option: 'com_menus',


                    task: 'item.ajax_get_menu_item'


                };
                option_click = $.param(option_click);
                var data_submit = {};
                var ajax_web_design = $.ajax({

                    contentType: 'application/json',

                    type: "POST",

                    dataType: "json",

                    url: root_ulr + 'index.php?' + option_click,

                    data: JSON.stringify(data_submit),

                    beforeSend: function () {

                        $element.bho88loading();

                    },

                    success: function (response) {

                        $element.bho88loading(true);

                        if (response.e == 0) {
                            console.log(response);
                            window.location.href = "http://banhangonline88.com/administrator/index.php?option=com_menus&task=item.edit&id=" + response.id;
                        } else if (response.e == 1) {

                            alert(response.m);

                        }


                    }

                });
            }

        }



        plugin.example_function = function() {



        }

        plugin.init();



    }



    // add the plugin to the jQuery.fn object

    $.fn.view_items_default = function(options) {



        // iterate through the DOM elements we are attaching the plugin to

        return this.each(function() {



            // if plugin has not already been attached to the element

            if (undefined == $(this).data('view_items_default')) {

                var plugin = new $.view_items_default(this, options);



                $(this).data('view_items_default', plugin);



            }



        });



    }



})(jQuery);
