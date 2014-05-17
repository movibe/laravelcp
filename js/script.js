function include(url){document.write('<script type="text/javascript" src="'+url+'"></script>')}

//------ base included scripts -------//
include('js/jquery.easing.js');
include('js/jquery.flexslider-min.js');   
include('js/TMForm.js');

if(!FJSCore.mobile){
    include('js/jquery.onepage-scroll.js');
    include('js/hoverIntent.js');
    include('js/superfish.js');     
    include('js/spin.min.js');
    include('js/jquery.mousewheel.min.js');
    include('js/uScroll.js');
} 

var win = $(window),
    isIE9 = (navigator.appVersion.indexOf("MSIE 9")!==-1);

function initPlugins(){
    $('.flexslider').flexslider({
        animation: 'slide',
        slideshow: false
    });

    $('#form1').TMForm({
        ownerEmail:'#'
    });

    setTimeout(function () {
        $('.scroll').each(function () {
            var $this = $(this);
            if ($('>div',$this).outerHeight() > $this.outerHeight()) {
                $this
                .uScroll({          
                    mousewheel:true,
                    step: 30,
                    lay:'outside'
                })
                $('.scroll-btns', $this.parent()).css('display', 'block');
            } else {
                $('.scroll-btns', $this.parent()).css('display', 'none');
            }
        })
    }, 500);
}

win
.on('orientationchange',function(e){
    $('.scroll').each(function () {
        var $this = $(this);

        if ($('>div', $this).outerHeight() <= $this.outerHeight()) {
            $('>div', $this).css('top',0);
            $this.siblings('.scroll-btns').css('display', 'none');
        } else{
            $this.siblings('.scroll-btns').css('display', 'block');
            $this
            .uScroll({          
                mousewheel:true,
                step: 30,
                lay:'outside'
            })
        }
    })
})
.on('resize',function(){ win.trigger('orientationchange') })

function spinnerInit(){    
    var opts = {
        lines: 11,
        length: 10,
        width: 5,
        radius: 14, 
        corners: 1,
        color: '#fff', 
        speed: 1.3,
        trail: 50
    }
    spinner = new Spinner(opts).spin($('#webSiteLoader')[0]);
    spinner2 = new Spinner(opts).spin($('#imgSpinner')[0]);
}

$(function(){
    $("#year").text((new Date).getFullYear());
    
    initPlugins();

    if(FJSCore.mobile){
        $('body').css({'minWidth':'auto'});
        FJSCore.defState = 'home';
        $('#mobile-navigation > option').eq(0).remove();
        $(document)
        .on('show','#mobile-content>*', function(e,d){    
            setTimeout(function (){ win.trigger('resize'); }, 50);
        })              
        .on('hide','#mobile-content>*',function(e,d){
        })
    } else {
        spinnerInit();
        $('#mainNav').superfish({
            speed: 'fast',
            delay: 0
        });
    }
    
    var bodyClasses = $('body').attr('class');
    $('#other_pages2') 
        .on('show','>*',function(e,d){
            $('body').attr('class','');
            $.when(d.elements)
                .then(function(){

                    $('#other_pages2').stop(true).animate({'top':'0'});        
                    initPlugins();

                    d.curr
                        .stop()
                        .css({'display':'block', 'opacity': '0'})
                        .animate({'opacity': '1' }, 0, function(){ 
                            $(this).addClass('activePage'); 
                        })
                })         
        })
        .on('hide','>*',function(e,d){    
            $('body').attr('class',bodyClasses);

            $('#other_pages2').stop(true).animate({'top':'-100%'});         
            $(this)
                .removeClass('activePage')
                .stop()
                .animate({ 'opacity': '0' }, 500, function(){
                    $(this).css('display','none');
                });           
        })	
})
/*---------------------- end ready -------------------------------*/


win
.load(function(){  
    setTimeout(function () {
        $("#webSiteLoader").fadeOut(500, function(){
            $("#webSiteLoader").remove();
        });
        win.trigger('resize');
    }, 1000);

    if(!FJSCore.mobile){
        
        $("#other_pages").onepage_scroll({
            sectionContainer: ".page",
            easing: 'easeInOutCubic',
            updateURL: false,
            pagination: false
        });
        var menuLen = $('#mainNav>ul>li').length;
        $('.onepage-pagination>li').each(function (ind,el){
            (ind >= menuLen) && $(this).addClass('hiddenElement');
        })
    }else{
        //----- mobile scripts ------//
        $('#mobile-header>*').wrapAll('<div class="container"></div>');
        $('#mobile-footer>*').wrapAll('<div class="container"></div>');
    }
    win.trigger('afterload');
});