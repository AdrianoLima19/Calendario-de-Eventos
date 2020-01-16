function load(reload) {
    $.ajax({

        url: 'src/readContent.php'

    }).done(function(data){

        eval(data)
        $(".contentList").remove()
        $(".tableTitle").after(data)

        if(reload) {
            $.ajax({
                url: '../calendar/src/load.php'
            }).done(function(data){
        
                eval(data)
                console.log(data)
                $("#selectColab").remove()
                $("#nullColab").after(data[1])
                $("#editnullColab").after(data[1])
                $("#selectPlace").remove()
                $("#nullPlace").after(data[0])
                $("#editnullPlace").after(data[0])
        
            })
        }

        deleteModalOptions()
        loadVerify()
    })
}

$( document ).ready(function() {
    load(true)
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

$('.closeSpace').click(function() {
    $('.closeSpace').css('display', 'none')
    $('.createModal').css('display', 'none')
    $('.editModal').css('display', 'none')
})
