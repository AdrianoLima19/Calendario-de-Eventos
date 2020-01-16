$( ".form-group" ).submit(function( event ) {

    event.preventDefault();

    // Empty fields
        if($("#input-email").val() == "" && $("#input-password").val() == "") {

            $(".email-error").fadeIn( 150 ).css("display", "block");
            $(".password-error").fadeIn( 150 ).css("display", "block");

            if($(".login-error").css("display") == "block") { $(".login-error").fadeOut( 125 ).css("display", "none"); }

            return;

        }

        if($("#input-email").val() == "") {

            $(".email-error").fadeIn( 150 ).css("display", "block");
            if($(".login-error").css("display") == "block") { $(".login-error").fadeOut( 125 ).css("display", "none"); }

        }

        if($("#input-password").val() == "") {

            $(".password-error").fadeIn( 150 ).css("display", "block");
            if($(".login-error").css("display") == "block") { $(".login-error").fadeOut( 125 ).css("display", "none"); }

        }

    // Empty fields
    
    // Clean Errors
        if($("#input-email").val() != "") {

            if($(".email-error").css("display") == "block") {

                $("#input-email").css("border", "2px solid transparent");
    
                $(".email-error").fadeOut( 125 ).css("display", "none");
    
            }
        }

        if($("#input-password").val() != "") {
            
            if($(".password-error").css("display") == "block") {
            
                $("#input-password").css("border", "2px solid transparent");
    
                $(".password-error").fadeOut( 125 ).css("display", "none");
                
            }
        }

        if ( $(".email-error").css("display") == "block" || $(".password-error").css("display") == "block" ) {
            return;
        }
        console.log('checking login...')

    // Clean Errors

    // Loading...
        $( ".form-group" ).fadeOut( 125 ).css('display', 'none')
        $( ".spinPos" ).fadeIn( 150 ).css('display', 'flex')
    // Loading...

    var checkbox = ( $('#inputRememberMe').is(":checked") ) ? 'true' : 'false'
    $.ajax({
        url: 'checker/loginChecker.php',
        type: 'post',
        dataType: 'script',
        data: {
            'email': $("#input-email").val(),
            'password': $("#input-password").val(),
            'keepOn': checkbox
        }
    }).done(function(data){
        eval(data)
        console.log(data)
        if (data == 'error') {
            $( ".form-group" ).fadeIn( 150 ).css('display', 'block')
            $( ".spinPos" ).fadeOut( 125 ).css('display', 'none')
            $(".login-error").fadeIn( 200 ).css("display", "block");
            // hideSoftInputFromWindow(searchEditText.getWindowToken(), 0);
            return;
        } else {
            $( location ).attr("href", "../calendar/index.php");
        }
    });
});

$(".email-error").click( function() {
    $(".email-error").fadeOut( 125 ).css("display", "none");
});
$(".password-error").click( function() {
    $(".password-error").fadeOut( 125 ).css("display", "none");
});
$(".login-error").click( function() {
    $(".login-error").fadeOut( 125 ).css("display", "none");
});