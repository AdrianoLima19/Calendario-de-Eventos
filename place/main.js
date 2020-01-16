function load() {
    $.ajax({

        url: 'src/readContent.php'

    }).done(function(data){

        eval(data)
        $(".contentList").remove()
        $(".tableTitle").after(data)

        deleteModalOptions()
        createUpdate()
    })
}

$( document ).ready(function() {
    load()
})

function deleteModalOptions() {
    // open exclusion modal
        $("div #delete").click( function () {

            $("#contentID").val( this.dataset.id )
            $(".deleteName").replaceWith( '<span class="deleteName"> '+ this.dataset.content +'</span>' )
            
            $(".contentTable").css('display', 'none')
            $(".contentTitle").css('display', 'none')
            $(".contentOptions .contentAdd").css('display', 'none')

            $(".deleteModal").css('display', 'flex')

        })
    // open exclusion modal

    // cancel the delete
        $("#closeDeleteForm").click( function() {

            $("#contentID").val('')
            $(".deleteName").replaceWith( '<span class="deleteName"> :content </span>' )
            
            $(".contentTable").css('display', 'table')
            $(".contentTitle").css('display', 'block')
            $(".contentOptions .contentAdd").css('display', 'block')

            $(".deleteModal").css('display', 'none')
            
        })
    // cancel the delete

    // Delete Data
        $(".deleteModal").submit( function(e) {

            e.preventDefault()

            var deleteID = $("#contentID").val()

            $.ajax({
                url: 'src/delete.php',
                type: 'post',
                dataType: 'html',
                data: {
                    'id': deleteID
                }
            }).done( function(){

            // Reload Table
                // clean and reset
                    $("#contentID").val('')
                    $(".deleteName").replaceWith( '<span class="deleteName"> :content </span>' )
                    
                    $(".contentTable").css('display', 'table')
                    $(".contentTitle").css('display', 'block')
                    $(".contentOptions .contentAdd").css('display', 'block')

                    $(".deleteModal").css('display', 'none')
                // clean and reset
                load()
            // Reload Table
            })
        })
    // Delete Data
}

function createUpdate() {
    $(".check").change(function() {
        $(".check").prop("checked", false);
        $(this).prop("checked", true);
    })
    
    $(".btn-close-mod").click(function() {
        $(".closeSpace").fadeOut(25)
        $(".editModal").fadeOut(150)
        $(".createModal").fadeOut(150)
    })
    
    $(".contentAdd img").click(function() {
        $(".closeSpace").fadeIn(150).css('display', 'flex')
        $(".createModal").fadeIn(125).css('display', 'flex')
    })

    $(".btn-close-mod").click(function () {
        $('.formCreateModal').each (function(){ this.reset(); });
        $('.formEditModal').each (function(){ this.reset(); });
        $('.formCreateModal input').removeClass('error')
        $('.formEditModal input').removeClass('error')
        $('.div-error').css('display', 'none')

    })
    
    $("div #edit").click(function() {
        $.ajax({
            url: 'src/getDataModal.php',
            type: 'post',
            dataType: 'html',
            data: {
                'type': 'read',
                'id': this.dataset.id
            }
        }).done(function(data){
    
            eval(data)
            $("#placeID").val(data[0])
            $("#editPlaceName").val(data[1])
            if (data[2]) {
                $('#editActive').prop("checked", true);
                $('#editInactive').prop("checked", false);
            } else {
                $('#editActive').prop("checked", false);
                $('#editInactive').prop("checked", true);
            }
            $(".closeSpace").fadeIn(150).css('display', 'flex')
            $(".editModal").fadeIn(125).css('display', 'flex')
        })
    })
}

$('#createPlaceName').blur(function() {

    if ($('#createPlaceName').val() == "") {
        $('#createPlaceName').addClass('error')
    } else {
        $.ajax({
            url: 'src/verify.php',
            type: 'post',
            dataType: 'html',
            data: {
                'method': 'create',
                'type': 'place',
                'place': $('#createPlaceName').val()
            }
        }).done(function(data){
            
            eval(data)
            
            if (data[0] == 'true') {
                $('#createPlaceName').addClass('error')
            } else {
                $('#createPlaceName').removeClass('error')
            }
        })
    }
    
})

$("#createActive").click(function () {
    $(".div-error").fadeOut(100)
})
$("#createInactive").click(function () {
    $(".div-error").fadeOut(100)
})
$(".formCreateModal").submit(function(e) {
    
    e.preventDefault()
    var invalid = false;

    if ($('#createPlaceName').val() == "") {
        $('#createPlaceName').addClass('error')
        var invalid = true;
    } else {
        $.ajax({
            url: 'src/verify.php',
            type: 'post',
            dataType: 'html',
            data: {
                'method': 'create',
                'type': 'place',
                'place': $('#createPlaceName').val()
            }
        }).done(function(data){
            
            eval(data)
            
            if (data[0] == 'true') {
                $('#createPlaceName').addClass('error')
                var invalid = true;
            } else {
                $('#createPlaceName').removeClass('error')
            }
        })
    }

    if (!$("#createActive").is(':checked') && !$("#createInactive").is(':checked')) {
        $(".div-error").fadeIn(100)
        var invalid = true;
    }

    if (invalid) { return; }
    if ($("#createActive").is(':checked')) {
        var chk = 'active'
    } else if ($("#createInactive").is(':checked')) {
        var chk = 'inactive'
    }

    $.ajax({
        url: 'src/getDataModal.php',
        type: 'post',
        dataType: 'html',
        data: {
            'type': 'create',
            'place': $("#createPlaceName").val(),
            'isActive': chk
        }
    }).done(function(){
        load()

        $(".closeSpace").fadeOut( 25 )
        $(".createModal").fadeOut( 125 )

        $('.formCreateModal').each (function(){
            this.reset();
        });
    })
})

$('#editPlaceName').blur(function() {

    if ($('#editPlaceName').val() == "") {
        $('#editPlaceName').addClass('error')
    } else {
        $.ajax({
            url: 'src/verify.php',
            type: 'post',
            dataType: 'html',
            data: {
                'method': 'update',
                'type': 'place',
                'place': $('#editPlaceName').val(),
                'id': $("#placeID").val()
            }
        }).done(function(data){
            
            eval(data)

            if (data[0] == 'true') {
                $('#editPlaceName').addClass('error')
            } else {
                $('#editPlaceName').removeClass('error')
            }
        })
    }
})

$(".formEditModal .check").on('click', function () {

    var checkboxValue = this.value
    $.ajax({
        url: 'src/verify.php',
        type: 'post',
        dataType: 'html',
        data: {
            'method': 'update',
            'type': 'active',
            'id': $("#placeID").val()
        }
    }).done(function(data){
        
        eval(data)
        
        if (checkboxValue == 'inactive' && data[0] == 'true') {
            $('.div-error').fadeIn(100)
        } else {
            $('.div-error').fadeOut(100)
        }
    })
})

$(".formEditModal").submit(function(e) {

    e.preventDefault()
    var invalid = false
    if (!$("#editActive").is(':checked') && !$("#editInactive").is(':checked')) {
        var invalid = true
    }
    
    if ($('#editPlaceName').val() == "") {
        $('#editPlaceName').addClass('error')
        var invalid = true
    } else {
        $.ajax({
            url: 'src/verify.php',
            type: 'post',
            dataType: 'html',
            data: {
                'method': 'update',
                'type': 'place',
                'place': $('#editPlaceName').val(),
                'id': $("#placeID").val()
            }
        }).done(function(data){
            
            eval(data)

            if (data[0] == 'true') {
                $('#editPlaceName').addClass('error')
                var invalid = true
            } else {
                $('#editPlaceName').removeClass('error')
            }
        })
    }

    if ($("#editActive").is(':checked')) {
        var chk = 'active'
    } else if ($("#editInactive").is(':checked')) {
        var chk = 'inactive'
    }

    $.ajax({
        url: 'src/verify.php',
        type: 'post',
        dataType: 'html',
        data: {
            'method': 'update',
            'type': 'active',
            'id': $("#placeID").val()
        }
    }).done(function(data){
        
        eval(data)
        
        if (chk == 'inactive' && data[0] == 'true') {
            $('.div-error').fadeIn(100)
        } else {
            $('.div-error').fadeOut(100)
            console.log('valid check')
        }
    })
    if($(".div-error").css('display') != 'none') { return; }
    if (invalid) { return; }

    $.ajax({
        url: 'src/getDataModal.php',
        type: 'post',
        dataType: 'html',
        data: {
            'type': 'update',
            'id': $("#placeID").val(),
            'place': $("#editPlaceName").val(),
            'isActive': chk
        }
    }).done(function(){
        load()

        $(".closeSpace").fadeOut( 25 )
        $(".editModal").fadeOut( 125 )
    })
})