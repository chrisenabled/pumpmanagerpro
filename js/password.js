$(function(){
    $('.password').keyup(function(e) {
        var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
        var mediumRegex = new RegExp("^(?=.{6,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
        var weakRegex = new RegExp("(?=.{4,}).*", "g");

        var password = $(this).val();
        if(false == weakRegex.test(password))
        {
            $('.progressBar').css('background', 'indianred');
        }
        else if(strongRegex.test(password))
        {
            $('.progressBar').css('background', '#67ba46');

        }
        else if(mediumRegex.test(password))
        {
            $('.progressBar').css('background', 'orange');

        }
        else
        {
            $('.progressBar').css('background', '#cd7a48');

        }
    });
});