    function serveContent(url){
        var myRand = parseInt(Math.random()* new Date().getTime());
        var modUrl = url+"?rand="+myRand;
        jQuery.ajax({
            url: modUrl,
            type: 'GET',
            dataType: 'HTML',
            cache: false,
            beforeSend: function(){
                $( "#page" ).fadeTo( 250 , 0, function() {
                    $("#page").html('<div class="ajax-status"><img src="/pmp/images/loading.gif">Loading...</div>').animate({opacity: 1},500);
                });
            },
            success: function(res, textStatus, jqXHR){
                $( "#page" ).fadeTo( 250 , 0, function() {
                    $("#page").html(res).animate({opacity: 1},200);
                });
            },
            error: function(jqXHR, textStatus, errorThrown){
                $( "#page" ).fadeTo( 500 , 0, function() {
                    $("#page").html('<div class="ajax-status" id="error"><img src="/pmp/images/error.png"><br/>An Error has occurred: '
                        + textStatus.text + '<br/><a href="#">Report</a></div>').animate({opacity: 1},100);
                });
            }
        });
    }


