
(function($)
{
	$(document).ready(function()
	{
		$("ul.nav#menu_adv li.dropdown>.dropdown-menu").css("margin-top",0)

    var submenuItem=$("li.dropdown-submenu > ul.dropdown-menu").find(">:not(li.dropdown-submenu)").parent().parent()
    submenuItem.hover(function() {
      var dropdown=$(this).find(">ul.dropdown-menu")
      dropdown.css({
        "max-height":500,
        "overflow-y":"auto"
      })
    },
    function() {})

    // var submenuItem=$("li.dropdown-submenu > ul.dropdown-menu#menu-com-plugins").find(">:not(li.dropdown-submenu)").parent().parent()
    var submenuItem=$("li.dropdown-submenu > ul.dropdown-menu#menu-com-plugins > li.dropdown-submenu").parent().parent()
    submenuItem.hover(function() {
      var dropdown=$(this).find(">ul.dropdown-menu")
      dropdown.css({
        "max-height":500,
        "overflow":"visible"
      })
    },
    function() {})

    $("ul.nav#menu_adv li.dropdown").hover(function(){
      var menu=$(this).find(">.dropdown-menu")[0]
      $(menu).show()
    },function(){
      $(this).find(">.dropdown-menu").hide()
    })

	});
})(jQuery);
