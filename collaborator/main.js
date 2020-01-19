function load() {
    $.ajax({

        url: 'src/readContent.php'

    }).done(function(data){

        eval(data)
        $(".contentList").remove()
        $(".tableTitle").after(data)

        deleteModalOptions()
        update()
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

// Close Modal
    $(".closeSpace").click(function () {
        $(".closeSpace").fadeOut(1)
        $(".createModal").fadeOut(150)
        $(".editModal").fadeOut(150)
    })
    $(".closeClick").click(function () {
        $(".closeSpace").fadeOut(1)
        $(".createModal").fadeOut(150)
        $(".editModal").fadeOut(150)
    })
// Close Modal
// Create
    //Open
        $(".contentAdd img").click(function () {
            $('.formCreate').each (function(){ this.reset(); });
            $('input').removeClass('error');
            $('select').removeClass('error');

            $(".createModal").fadeIn(150).css('display', 'flex')
            $(".closeSpace").fadeIn(150).css('display', 'flex')
        })
    // Open
    // Verify
        function verify(name, verify,method,id) {

            if ($(name).val() == "") {

                $(name).addClass('error')

            } else {

                if (verify == 'yes') {
                    $.ajax({
                        url: 'src/check.php',
                        type: 'post',
                        dataType: 'html',
                        data: {
                            'method': method,
                            'id': id,
                            'email': $(name).val()
                        }
                    }).done( function(data){
                        eval(data)
                        if (data[0] == 'true') {
                            $(name).addClass('error')
                        } else {
                            $(name).removeClass('error')
                        }
                    })
                } else {
                    $(name).removeClass('error')
                }
            }
        }
        
        $('#colabName').blur(function () {
            verify('#colabName', 'no')
        })
        $('#colabName').change(function () {
            verify('#colabName', 'no')
        })

        $('#colabProfile').blur(function () {
            verify('#colabProfile', 'no')
        })
        $('#colabProfile').change(function () {
            verify('#colabProfile', 'no')
        })

        $('#colabEmail').blur(function () {
            verify('#colabEmail', 'yes','create','')
        })

        $('#colabPassword').blur(function () {
            verify('#colabPassword', 'no')
        })
        $('#colabPassword').change(function () {
            verify('#colabPassword', 'no')
        })
    // Verify
    // Submit
        $('.formCreate').submit(function (e) {
            e.preventDefault()

            verify('#colabName', 'no')
            verify('#colabProfile', 'no')
            verify('#colabEmail', 'yes','create','')
            verify('#colabPassword', 'no')

            if ($('#colabName').hasClass('error')) { return;}
            if ($('#colabProfile').hasClass('error')) { return;}
            if ($('#colabEmail').hasClass('error')) { return;}
            if ($('#colabPassword').hasClass('error')) { return;}

            $.ajax({
                url: 'src/save.php',
                type: 'post',
                dataType: 'html',
                data: {
                    'method': 'create',
                    'id': '',
                    'name': $('#colabName').val(),
                    'profile': $('#colabProfile').val(),
                    'email': $('#colabEmail').val(),
                    'password': $('#colabPassword').val()
                }
            }).done( function(){
                $(".closeSpace").fadeOut(1)
                $(".createModal").fadeOut(150)
                load()
            })
            
        })
    // Submit
// Create
// Update
    function update() {
        //Open
            $(".contentList #edit").click(function () {
                $("#editID").val(this.dataset.id)
                $.ajax({
                    url: 'src/getData.php',
                    type: 'post',
                    dataType: 'html',
                    data: {
                        'id': this.dataset.id
                    }
                }).done( function(data){
                    eval(data)

                    $('input').removeClass('error');
                    $('select').removeClass('error');

                    $('#editName').val(data[0])
                    $('#editEmail').val(data[1])
                    $('#editProfile').val(data[2])

                    $(".editModal").fadeIn(150).css('display', 'flex')
                    $(".closeSpace").fadeIn(150).css('display', 'flex')
                });
            });
        // Open
    }
    // Verify
        $('#editName').blur(function () {
            verify('#editName', 'no')
        })
        $('#editName').change(function () {
            verify('#editName', 'no')
        })
        $('#editProfile').change(function () {
            verify('#editProfile', 'no')
        })
        $('#editEmail').blur(function () {
            verify('#editEmail', 'yes','update',$("#editID").val())
        })
    // Verify
    // Submit
        $('.formEdit').submit(function (e) {
            e.preventDefault()

            verify('#editName', 'no')
            verify('#editProfile', 'no')
            verify('#editEmail', 'yes','update',$("#editID").val())

            if ($('#editName').hasClass('error')) { return;}
            if ($('#editProfile').hasClass('error')) { return;}
            if ($('#editEmail').hasClass('error')) { return;}

            $.ajax({
                url: 'src/save.php',
                type: 'post',
                dataType: 'html',
                data: {
                    'method': 'update',
                    'id': $("#editID").val(),
                    'name': $('#editName').val(),
                    'profile': $('#editProfile').val(),
                    'email': $('#editEmail').val(),
                }
            }).done( function(){
                $(".closeSpace").fadeOut(1)
                $(".editModal").fadeOut(150)
                load()
            })
            
        })
    // Submit
// Update