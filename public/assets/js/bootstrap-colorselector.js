(function(e){var t=function(t,n){this.options=n;this.$select=e(t);this._init()};t.prototype={constructor:t,_init:function(){var t=this.options.callback;var n=this.$select.val();var r=this.$select.find("option:selected").data("color");var i=e("<ul>").addClass("dropdown-menu").addClass("dropdown-caret");var s=e("<div>").addClass("btn-group").addClass("dropdown-colorselector");var o=e("<span>").addClass("btn-colorselector").css("background-color",r);var u=e("<a>").attr("data-toggle","dropdown").css("border-left","0").addClass("btn panel-color hide-full btn-default btn-sm dropdown-toggle").attr("href","#").append(o);e("option",this.$select).each(function(){var t=e(this);var r=t.attr("value");var s=t.data("color");var o=t.text();var u=e("<a>").addClass("color-btn");if(t.prop("selected")===true||n===s){u.addClass("selected")}u.css("background-color",s);u.attr("href","#").attr("data-color",s).attr("data-value",r).attr("title",o);i.append(e("<li>").append(u))});s.append(u);s.append(i);e(".btn").button();this.$select.hide();this.$selector=e(s).insertAfter(this.$select);this.$select.on("change",function(){var n=e(this).attr("data-id");var r=e(this).val();var i=e(this).find("option[value='"+r+"']").data("color");var s=e(this).find("option[value='"+r+"']").text();e(this).next().find("ul").find("li").find(".selected").removeClass("selected");e(this).next().find("ul").find("li").find("a[data-color='"+i+"']").addClass("selected");e(this).next().find(".btn-colorselector").css("background-color",i);t(n,r,i,s)});i.on("click.colorselector",e.proxy(this._clickColor,this))},_clickColor:function(t){var n=e(t.target);if(!n.is(".color-btn")){return false}this.$select.val(n.data("value")).change();t.preventDefault();return true},setColor:function(t){var n=e(this.$selector).find("li").find("a[data-color='"+t+"']").data("value");this.setValue(n)},setValue:function(e){this.$select.val(e).change()}};e.fn.colorselector=function(n){var r=Array.apply(null,arguments);r.shift();return this.each(function(){var i=e(this),s=i.data("colorselector"),o=e.extend({},e.fn.colorselector.defaults,i.data(),typeof n=="object"&&n);if(!s){i.data("colorselector",s=new t(this,o))}if(typeof n=="string"){s[n].apply(s,r)}})};e.fn.colorselector.defaults={callback:function(e,t,n,r){},colorsPerRow:8};e.fn.colorselector.Constructor=t})(jQuery,window,document)