function setNavigation() {
    var path = window.location.pathname;
    var location = window.location.href;
    path = path.replace(/\/$/, "");
    path = decodeURIComponent(path);

    $("#menu li a").each(function () {
        var href = $(this).attr('href');
        if (path.substring(0, href.length) === href || location === href ) {
            $(this).closest('li').addClass('active');
        }

        if(path == "/portal/home"){
           // carrousel();
            /*
            function Rotate() {
                var $current = $rotator.find("img:visible");
                var $next = $current.next();
                if ($next.length == 0) $next = $rotator.find("img:eq(0)");
                $current.hide();
                $next.show();
                setTimeout(Rotate, 4000);
            }
            var $rotator = $("#banners");
            $rotator.find("img:gt(0)").hide();
            setTimeout(Rotate, 3000);*/
            $('#featured_slide').cycle({
                timeout: 5000,
                fx: 'fade',
                pager: '#fs_pagination',
                pause: 1,
                pauseOnPagerHover: 0
            });



        }
    });
}




$(function () {
    setNavigation();

    $('ul.first').bsPhotoGallery({
        "classes" : "",
        "hasModal" : true
    });

    $('a[data-href="familia"]').on('click', function (e) {
        var $this = $(this);
        var target = $this.attr('data-href');
        setTimeout(function(){
            $('.tab-pane').nextAll().addClass('active');
        },0);

        console.log(target);
    })

    String.prototype.capitalize = function() {
      return this.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });
    };

    var pathname = window.location.pathname; // Returns path only
    var trechos  = pathname.split('/');

    $('.breadcrumb').append('<li><a href="'+app_url+'">Home</a></li>');

    var link = '';

    trechos.forEach(function(entry) {
    link += '/' + entry;
    if (entry!='portal' && entry!='home' && entry)
      $('.breadcrumb').append('<li><a href="/'+link+'">'+entry.split('_').join(' ').capitalize()+'</a></li>');
    });

    $('.breadcrumb li').last().addClass('active').attr('href',null);
    $('.breadcrumb li:last a').contents().unwrap();
});