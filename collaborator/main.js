function load() {
    $.ajax({

        url: 'src/readContent.php'

    }).done(function(data){

        eval(data)
        $(".contentList").remove()
        $(".tableTitle").after(data)

        deleteModalOptions()
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

// Create
    $(".contentAdd img").click(function () {
        $(".createModal").fadeIn(150).css('display', 'flex')
    })
// Create

// Update