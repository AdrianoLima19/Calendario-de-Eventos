/*
* loadMonth loads the selected month and its month events. 
* The other features are built into functions because some features used are loaded via ajax 
* or check components that have not yet been loaded, these functions are called after the data 
* is loaded ensuring full functionality
*/

function loadMonth(ym, reload) {

    now = new Date

    $.ajax({

        url: 'src/calendar.php',
        type: 'get',
        dataType: 'html',
        data: {
            'ym': ym
        }

    }).done(function(data){

        eval(data)
        $('.monthTitle').replaceWith('<h2 class="monthTitle">'+data[5]+'</h2>');
        $(".calendar-week").remove()
        $(".space").after(data[0])
        $("#hpy").val(data[2])
        $("#hpm").val(data[1])
        $("#hny").val(data[4])
        $("#hnm").val(data[3])
        $("#actualMonthDisplay").val(data[6])
        var hbtn = ((now.getMonth() + 1) < 10 ? '0' : '') + (now.getMonth() + 1);
        $("#hbtn-today").val(now.getFullYear() + "-" + hbtn)

    })

    $.ajax({

        url: 'src/eventMap.php',
        type: 'get',
        dataType: 'html',
        data: {
            'ym': ym
        }

    }).done(function(data){

        eval(data)
        $(".event-table").remove()
        $(".event-calendar").html(data[0])
        $(".leftEventBlock").remove()
        $(".leftEventScroll").html(data[1])

        if(reload) {
            $.ajax({
                url: 'src/load.php'
            }).done(function(data){
        
                eval(data)
                $("select #selectColab").remove()
                $("#selectColabNull").after(data[1])
                $("select #selectPlace").remove()
                $("#selectPlaceNull").after(data[0])
        
            })
        }

        modalListener()
        leftAsideSW()
        updateAside()
        asideModalDelete()
        showMore()
    })

}

// On page load
    $( document ).ready(function() {

        now = new Date
        var mr = ((now.getMonth() + 1) < 10 ? '0' : '') + (now.getMonth() + 1);
        loadMonth(now.getFullYear() + "-" + mr,true)

    })
// On page load

// Navigation Buttons
    $("#search-form").submit(function (e) {

        e.preventDefault()

        if($("#month-search").val() == "") {
            return;
        }

        data = $("#month-search").val()

        $('#month-search').val('')
        $('#month-search').trigger("blur");

        loadMonth(data)
    })
    $("#btn-search").click(function () {

        if($("#month-search").val() == "") {
            return;
        }

        data = $("#month-search").val()

        $('#month-search').val('')
        $('#month-search').trigger("blur");

        loadMonth(data)
    })

    $("#btn-today").click(function () { // Today

        data = $("#hbtn-today").val()
        loadMonth(data)
    })

    $("#pm").click(function () { // Previus month

        data = $("#hpm").val()
        loadMonth(data)
    })
    $("#py").click(function () { // Previus Year

        data = $("#hpy").val()
        loadMonth(data)
    })
    $("#nm").click(function () { // Next month

        data = $("#hnm").val()
        loadMonth(data)
    })
    $("#ny").click(function () { // Next year

        data = $("#hny").val()
        loadMonth(data)
    })
// Navigation Buttons

// Modal Open/Close/Listener
    function resetModalStatus() {

        $('input').removeClass('error');
        $('select').removeClass('error');

        $("#inputTitle").attr('readonly', false)
        $("#inputStartDay").attr('readonly', false)
        $("#inputStartTime").attr('readonly', false)
        $("#inputEndDay").attr('readonly', false)
        $("#inputEndTime").attr('readonly', false)
        $("#inputPlace").attr('readonly', false)
        $("#inputColab").attr('readonly', false)
        $("#inputType").attr('readonly', false)
        $("#inputPlace option:not(:selected)").attr('disabled', false)
        $("#inputPlace option:selected").attr('disabled', false)
        $("#inputColab option:not(:selected)").attr('disabled', false)
        $("#inputColab option:selected").attr('disabled', false)
        $("#inputType option:not(:selected)").attr('disabled', false)
        $("#inputType option:selected").attr('disabled', false)

        $("#inputTitle").removeClass('readonly')
        $("#inputStartDay").removeClass('readonly')
        $("#inputStartTime").removeClass('readonly')
        $("#inputEndDay").removeClass('readonly')
        $("#inputEndTime").removeClass('readonly')
        $("#inputPlace").removeClass('readonly')
        $("#inputColab").removeClass('readonly')
        $("#inputType").removeClass('readonly')
    }

    function openModal(type,set) {

        resetModalStatus()

        if (type == 'create') {

            $("#btn-sub-modal").val('Adicionar');
            var cdate = new Date()
            var cday = (cdate.getDate() < 10 ? '0' : '') + (cdate.getDate() + 1);
            var cmonth1 = ((cdate.getMonth() + 1) < 10 ? '0' : '') + (cdate.getMonth() + 1);
            var cmonth2 = ((cdate.getMonth() + 2) < 10 ? '0' : '') + (cdate.getMonth() + 2);
            var cset1 = cdate.getFullYear()+'-'+cmonth1+'-'+cday
            var cset2 = cdate.getFullYear()+'-'+cmonth2+'-'+cday

            $("#inputStartDay").attr("min", cset1)
            $("#inputEndDay").attr({"min": cset1, "max": cset2})
            $("#inputStartTime").val('08:00');
            $("#inputEndTime").val('22:00');

        } else if (type == 'dayCreate') {

            $('.modal').each (function(){ this.reset(); });
            var slc = new Date(set)
            var slcday = (slc.getDate() < 10 ? '0' : '') + (slc.getDate() + 1);
            var slcmonth = ((slc.getMonth() + 2) < 10 ? '0' : '') + (slc.getMonth() + 2);
            var slcset = slc.getFullYear()+'-'+slcmonth+'-'+slcday

            $("#inputStartDay").val(set);
            $("#inputEndDay").val(set);
            $("#inputEndDay").attr({"min": set, "max": slcset})
            $("#inputStartTime").val('08:00');
            $("#inputEndTime").val('22:00');
            
            $("#btn-sub-modal").val('Adicionar');
            
        } else if (type == 'update') {

            $('.modal').each (function(){ this.reset(); });

            var id = set

            $.ajax({

                url: 'src/getEvent.php',
                type: 'post',
                dataType: 'html',
                data: {
                    'id': id
                }
        
            }).done(function(data){
        
                eval(data)
                
                $("#eventID").val( data[0] )
                $("#inputTitle").val( data[1] )
                $("#inputColab").val( data[2] )
                $("#inputStartDay").val( data[3] )
                $("#inputStartTime").val( data[4] )
                $("#inputEndDay").val( data[5] )
                $("#inputEndTime").val( data[6] )
                $("#inputPlace").val( data[7] )
                $("#txtEvent").val( data[8] )
                $("#inputCompany").val( data[9] )
                $("#inputClient").val( data[10] )
                $("#inputPhone").val( data[11] )
                $("#inputEmail").val( data[12] )
                $("#txtClient").val( data[13] )
                $("#inputType").val( data[14] )

                $("#inputEndDay").attr("min", data[3])

                if ( data[15] ) {
                    $("#inputTitle").attr('readonly', true)
                    $("#inputStartDay").attr('readonly', true)
                    $("#inputStartTime").attr('readonly', true)
                    $("#inputEndDay").attr('readonly', true)
                    $("#inputEndTime").attr('readonly', true)
                    $("#inputPlace").attr('readonly', true)
                    $("#inputColab").attr('readonly', true)
                    $("#inputType").attr('readonly', true)
                    $("#inputPlace option:not(:selected)").attr('disabled', true)
                    $("#inputColab option:not(:selected)").attr('disabled', true)
                    $("#inputType option:not(:selected)").attr('disabled', true)

                    $("#inputTitle").addClass('readonly')
                    $("#inputStartDay").addClass('readonly')
                    $("#inputStartTime").addClass('readonly')
                    $("#inputEndDay").addClass('readonly')
                    $("#inputEndTime").addClass('readonly')
                    $("#inputPlace").addClass('readonly')
                    $("#inputColab").addClass('readonly')
                    $("#inputType").addClass('readonly')
    
                } else {
                    $("#inputTitle").attr('readonly', false)
                    $("#inputStartDay").attr('readonly', false)
                    $("#inputStartTime").attr('readonly', false)
                    $("#inputEndDay").attr('readonly', false)
                    $("#inputEndTime").attr('readonly', false)
                    $("#inputPlace").attr('readonly', false)
                    $("#inputColab").attr('readonly', false)
                    $("#inputType").attr('readonly', false)
                    $("#inputPlace option:not(:selected)").attr('disabled', false)
                    $("#inputPlace option:selected").attr('disabled', false)
                    $("#inputColab option:not(:selected)").attr('disabled', false)
                    $("#inputColab option:selected").attr('disabled', false)
                    $("#inputType option:not(:selected)").attr('disabled', false)
                    $("#inputType option:selected").attr('disabled', false)

                    $("#inputTitle").removeClass('readonly')
                    $("#inputStartDay").removeClass('readonly')
                    $("#inputStartTime").removeClass('readonly')
                    $("#inputEndDay").removeClass('readonly')
                    $("#inputEndTime").removeClass('readonly')
                    $("#inputPlace").removeClass('readonly')
                    $("#inputColab").removeClass('readonly')
                    $("#inputType").removeClass('readonly')
                }
            })

            $("#btn-sub-modal").val('Atualizar');

        }

        $(".modal").fadeIn(150).css('display', 'flex')

        if (type != 'update') {
            document.getElementById('inputTitle').focus();
        }

    }

    // Close Modal
        function closeModal(reset) {

            if ( $("#btn-sub-modal").val() == 'Atualizar' || reset) {

                $(".modal").fadeOut(150)
                $('.modal').each (function(){ this.reset(); });

            } else {

                $(".modal").fadeOut(150)

            }

        }
    // Close Modal

    // Buttons
        function modalListener() {

            $(".btn-add input").click(function () {
            
                openModal('create')
            
            })
            $(".thisDay").click(function () {
                
                openModal('dayCreate',this.dataset.date)
            
            })
            $(".event-list").click(function () {
                
                openModal('update',this.dataset.date)
            
            })
    
            // Close
                $(".close-bg").click(function () {
                    
                    closeModal()
                
                })
                $(".btn-close-mod").click(function () {
                    
                    closeModal(true)
                
                })
            // Close
        }
    // Buttons
// Modal Open/Close/Listener

// Submit

    $(".modal").submit(function (submit) {

        submit.preventDefault()

        globalVerify('#inputTitle')
        globalVerify('#inputColab')
        globalVerify('#inputType')
        globalVerify('#inputPlace')
        globalVerify('#inputStartDay')
        globalVerify('#inputEndDay')
        globalVerify('#inputStartTime')
        globalVerify('#inputEndTime')

        datetimeVerify('date','start',$("#inputStartDay").val(),0,"#inputStartDay")
        submitVerify('#inputStartDay')
        if(verify == 'true') { return; }

        datetimeVerify('date','end',$("#inputStartDay").val(),$("#inputEndDay").val(),"#inputEndDay")
        submitVerify('#inputEndDay')
        if(verify == 'true') { return; }

        datetimeVerify('time','start',$("#inputStartTime").val()+':00',0,"#inputStartTime")
        submitVerify('#inputStartTime')
        if(verify == 'true') { return; }

        datetimeVerify('time','end',$("#inputStartTime").val()+':00',$("#inputEndTime").val()+':00',"#inputEndTime")
        submitVerify('#inputEndTime')
        if(verify == 'true') { return; }

        substart = $("#inputStartDay").val()+' '+$("#inputStartTime").val()+':00';
        subend = $("#inputEndDay").val()+' '+$("#inputEndTime").val()+':00';
        placeCheck($("#inputPlace").val(),substart,subend)
        submitVerify('#inputPlace')
        if(verify == 'true') { return; }

        submitVerify('#inputTitle')
        if(verify == 'true') { return; }
        submitVerify('#inputColab')
        if(verify == 'true') { return; }
        submitVerify('#inputType')
        if(verify == 'true') { return; }

        if ($("#btn-sub-modal").val() == 'Atualizar') {
            var method = 'update'
        } else {
            var method = 'create'
        }

        $.ajax({
            url: 'src/saveEvent.php',
            type: 'post',
            dataType: 'html',
            data: {
                'action': method,
                'ID': $("#eventID").val(),
                'Title': $("#inputTitle").val(),
                'Colab': $("#inputColab").val(),
                'StartDay': $("#inputStartDay").val(),
                'StartTime': $("#inputStartTime").val(),
                'EndDay': $("#inputEndDay").val(),
                'EndTime': $("#inputEndTime").val(),
                'Place': $("#inputPlace").val(),
                'txtEvent': $("#txtEvent").val(),
                'Company': $("#inputCompany").val(),
                'Client': $("#inputClient").val(),
                'Phone': $("#inputPhone").val(),
                'Email': $("#inputEmail").val(),
                'txtClient': $("#txtClient").val(),
                'Type': $("#inputType").val()
            }
        }).done(function(data){
            $(".modal").fadeOut( 100 )
            loadMonth( $("#actualMonthDisplay").val(),true)
            $('.modal').each (function(){ this.reset(); });
        })

    })

    // Functions
        function placeCheck(place,start,end,id) {

            if (!$("#inputPlace").hasClass('readonly')) {
                if ($("#inputPlace").val() == "") {
                    $("#inputPlace").addClass('error')
                } else {
                    $.ajax({

                        url: 'src/checkPlace.php',
                        type: 'post',
                        dataType: 'html',
                        data: {
                            'place': place,
                            'start': start,
                            'end': end,
                            'id': id
                        }
                
                    })
                    .done(function(data){
                
                        eval(data)
                        
                        if (data[0] == 1) {
                            
                            $("#inputPlace").removeClass('error')
        
                        } else {
        
                            $("#inputPlace").addClass('error')
        
                        }
                    })
                }
            }
        }

        function datetimeVerify(method,is,start,end,name) {
            
            if (method == 'date') {
                
                if (is == 'start' && start != "") {
                    
                    $.ajax({

                        url: 'src/checkTime.php',
                        type: 'post',
                        dataType: 'html',
                        data: {
                            'method': method,
                            'type': is,
                            'dateStart': start
                        }
                
                    })
                    .done(function(data){
                        
                        eval(data)
                        
                        if (data[0] == 'true') {
                            $(name).removeClass('error')
                            $("#inputEndDay").attr({"min": data[1], "max": data[2]})
                        } else {
                            $(name).addClass('error')
                        }
                    })

                } else if (is == 'end' && end != "" && start != "") {

                    $.ajax({

                        url: 'src/checkTime.php',
                        type: 'post',
                        dataType: 'html',
                        data: {
                            'method': method,
                            'type': is,
                            'dateStart': start,
                            'dateEnd': end
                        }
                
                    })
                    .done(function(data){
                
                        eval(data)

                        if (data[0] == 'true') {
                            $(name).removeClass('error')
                        } else {
                            $(name).addClass('error')
                        }
                    })

                } else { $(name).addClass('error') }

            } else if (method == 'time') {

                if (is == 'start' && start != ":00") {
                    
                    $.ajax({

                        url: 'src/checkTime.php',
                        type: 'post',
                        dataType: 'html',
                        data: {
                            'method': method,
                            'type': is,
                            'timeStart': start
                        }
                
                    })
                    .done(function(data){
                
                        eval(data)
                        
                        if (data[0] == 'true') {
                            $(name).removeClass('error')
                        } else {
                            $(name).addClass('error')
                        }
                    })

                } else if (is == 'end' && end != ":00" && start != ":00") {
                    
                    $.ajax({

                        url: 'src/checkTime.php',
                        type: 'post',
                        dataType: 'html',
                        data: {
                            'method': method,
                            'type': is,
                            'timeStart': start,
                            'timeEnd': end
                        }
                
                    })
                    .done(function(data){
                
                        eval(data)

                        if (data[0] == 'true') {
                            $(name).removeClass('error')
                        } else {
                            $(name).addClass('error')
                        }
                    })
                }
                
            }
        }

        function submitVerify(name) {

            if (!$(name).hasClass('readonly')) {
                if ($(name).hasClass('error')) {
                    return verify = 'true';
                } else { return  verify = 'false'; }
            } else { return  verify = 'false'; }

        }

        function globalVerify(name) {
            
            if (!$(name).hasClass('readonly')) {

                if ($(name).val() == "") {

                    $(name).addClass('error')

                } else {

                    $(name).removeClass('error')

                }

            }

        }

        function setTime() {

            if ($("#inputStartDay").val() != "" && $("#inputEndDay").val() != "") {
                if ($("#inputStartDay").val() != $("#inputEndDay").val()) {
                    $("#inputStartTime").val('08:00')
                    $("#inputStartTime").attr('readonly', true)
                    $("#inputEndTime").val('22:00')
                    $("#inputEndTime").attr('readonly', true)
                } else {
                    $("#inputStartTime").attr('readonly', false)
                    $("#inputEndTime").attr('readonly', false)
                }
            }
        }
    // Functions
    //Checker
        $("#inputTitle").blur(function () {

            globalVerify('#inputTitle')

        })

        $("#inputColab").change(function () {

            globalVerify('#inputColab')

        })

        $("#inputColab").blur(function () {

            globalVerify('#inputColab')

        })

        $("#inputType").change(function () {

            globalVerify('#inputType')

        })

        $("#inputType").blur(function () {

            globalVerify('#inputType')

        })
        
        $("#inputPlace").blur(function () {

            if (!$("#inputPlace").hasClass('readonly')) {

                if ( $("#inputStartDay").val() == "" || $("#inputEndDay").val() == "" || 
                    $("#inputStartTime").val() == "" || $("#inputEndTime").val() == "" ) {
                    
                    globalVerify('#inputPlace');
                    return;
                }

                if ($("#inputPlace").val() == "") {

                    $("#inputType").addClass('error')

                } else {

                    var plcID = ($("#eventID").val() != "" ? $("#eventID").val() : "");
                    var pl = $("#inputPlace").val();
                    var sDT = $("#inputStartDay").val()+' '+$("#inputStartTime").val()+':00';
                    var eDT = $("#inputEndDay").val()+' '+$("#inputEndTime").val()+':00';

                    placeCheck(pl,sDT,eDT,plcID)
                    
                }

            }

        })

        $("#inputPlace").change(function () {

            if (!$("#inputPlace").hasClass('readonly')) {

                if ( $("#inputStartDay").val() == "" || $("#inputEndDay").val() == "" || 
                    $("#inputStartTime").val() == "" || $("#inputEndTime").val() == "" ) {
                    
                    globalVerify('#inputPlace');
                    return;
                }

                if ($("#inputPlace").val() == "") {

                    $("#inputType").addClass('error')

                } else {

                    var plcID = ($("#eventID").val() != "" ? $("#eventID").val() : "");
                    var pl = $("#inputPlace").val();
                    var sDT = $("#inputStartDay").val()+' '+$("#inputStartTime").val()+':00';
                    var eDT = $("#inputEndDay").val()+' '+$("#inputEndTime").val()+':00';

                    placeCheck(pl,sDT,eDT,plcID)
                    
                }

            }

        })

        $("#inputStartDay").blur(function () {

            if (!$("#inputStartDay").hasClass('readonly')) {

                if ($("#inputStartDay").val() == "") {

                    $("#inputStartDay").addClass('error')

                } else {

                    var method = 'date';
                    var is = 'start';
                    var startDate = $("#inputStartDay").val();

                    datetimeVerify(method,is,startDate,0,'#inputStartDay')
                    
                }

            }

            setTime()
        })

        $("#inputEndDay").blur(function () {

            if (!$("#inputEndDay").hasClass('readonly')) {

                if ($("#inputEndDay").val() == "") {

                    $("#inputEndDay").addClass('error')

                } else {

                    if ($("#inputStartDay").val() == "") { $("#inputStartDay").addClass('error'); return; }

                    var method = 'date';
                    var is = 'end';
                    var startDate = $("#inputStartDay").val();
                    var endDate = $("#inputEndDay").val();

                    datetimeVerify(method,is,startDate,endDate,'#inputEndDay')
                    
                }

            }

            setTime()
        })

        $("#inputStartTime").blur(function () {

            setTime()

            if (!$("#inputStartTime").hasClass('readonly')) {

                if ($("#inputStartTime").val() == "") {

                    $("#inputStartTime").addClass('error')

                } else {

                    var method = 'time';
                    var is = 'start';
                    var startTime = $("#inputStartTime").val()+':00';
                    var endTime = ':00';

                    datetimeVerify(method,is,startTime,endTime,'#inputStartTime')
                    
                }

            }
        })

        $("#inputEndTime").blur(function () {

            setTime()

            if (!$("#inputEndTime").hasClass('readonly')) {

                if ($("#inputEndTime").val() == "") {

                    $("#inputEndTime").addClass('error')

                } else {

                    if ($("#inputStartTime").val() == "") { $("#inputStartTime").addClass('error'); return; }

                    var method = 'time';
                    var is = 'end';
                    var startTime = $("#inputStartTime").val()+':00';
                    var endTime = $("#inputEndTime").val()+':00';

                    datetimeVerify(method,is,startTime,endTime,'#inputEndTime')
                    
                }

            }
        })
    //Checker
// Submit

// Left Aside

    function leftAsideSW() {
        if ($(".left-btn-open").css('display') == 'block') {

            $(".leftAside").css('grid-column', '1/2')
            $(".calendar").css('grid-column', '2/13')
            $(".event-calendar").css('grid-column', '2/13')

            $(".leftEventBlock h4").css('color', 'transparent')
            $(".leftEventBlock div:first-child").css({'height': '4vh', 'user-select': 'none'})
            $(".leftEventBlock div:nth-child(2)").css('display', 'none')
            $(".leftEventBlock div:last-child").css('display', 'none')
            $(".leftEventScroll").css('overflow-y', 'hidden')

        } else if ($(".left-btn-close").css('display') == 'block') {

            $(".leftAside").css('grid-column', '1/4')
            $(".calendar").css('grid-column', '4/13')
            $(".event-calendar").css('grid-column', '4/13')

            $(".leftEventBlock h4").css('color', 'white')
            $(".leftEventBlock div:first-child").css({'height': 'max-content', 'user-select': 'text'})
            $(".leftEventBlock div:nth-child(2)").css('display', 'flex')
            $(".leftEventBlock div:last-child").css('display', 'flex')
            $(".leftEventScroll").css('overflow-y', 'auto')

        }
        showMoreReload()
    }

    // Open/Close Aside
        $(".left-btn-open").click(function () {
            $(".left-btn-open").fadeOut(125).css('display', 'none')
            $(".left-btn-close").fadeIn(125).css('display', 'block')
            leftAsideSW()
        })
        $(".left-btn-close").click(function () {
            $(".left-btn-close").fadeOut(125).css('display', 'none')
            $(".left-btn-open").fadeIn(125).css('display', 'block')
            leftAsideSW()
        })
    // Open/Close Aside

    // Open Modal
        function updateAside() {
            $(".leftEventBlock div:nth-child(2) img").click(function() {
                openModal('update',this.dataset.id)
            })
        }
    // Open Modal
    
    // Delete Modal
        function asideModalDelete() {
            // Open
                $(".leftEventBlock div:last-child img").click(function() {
                    $(".deleteModal .formDeleteModal .formOptions #contentID").val( this.dataset.id )
                    $(".deleteModal .formDeleteModal .deleteName").replaceWith('<span class="deleteName"> '+ this.dataset.name +'</span>')

                    $(".deleteModal").css('display', 'flex');
                })
            // Open
            // Close
                $("#closeDeleteForm").click( function() {
                    $(".deleteModal").css('display', 'none')
                    $("#contentID").val('')
                    $(".deleteName").replaceWith( '<span class="deleteName"> :content </span>' )
                })
            // Close
            // Delete
                $(".deleteModal").submit( function(e) {

                    e.preventDefault()
                    var deleteID = $("#contentID").val()
                    $.ajax({
                        url: '../event/src/delete.php',
                        type: 'post',
                        dataType: 'html',
                        data: {
                            'id': deleteID
                        }
                    }).done( function(){
                        loadMonth( $("#actualMonthDisplay").val(),true)
                        $(".deleteModal").css('display', 'none')
                        $("#contentID").val('')
                        $(".deleteName").replaceWith( '<span class="deleteName"> :content </span>' )
                    })
                })
            // Delete
        }
    // Delete Modal
// Left Aside

// More Events
    function showMoreReload() {
        $('.more-event #btn-show-more').each(function () {
            var tooltip = $(this).siblings().get(0)
            if ($(tooltip).css('display') == 'block') {
                
                var button = $(this).get(0)
                var width = $($($(this).siblings().get(0)).parents().get(0)).width()

                $(tooltip).width(width)

                Popper.createPopper(button,tooltip, {
                    placement: 'bottom',
                })
            }
        })
    }

    function showMore() {
        
        // Show More Events Open/Close
            $(".more-event #btn-show-more").click(function () {
                $(this).siblings().slideToggle(100)
                var button = $(this).get(0)
                var tooltip = $(this).siblings().get(0)
                var arrow = $(this).siblings().children().get(0)
                var page = $('.container').get(0)
                var width = $($($(this).siblings().get(0)).parents().get(0)).width()
                $(tooltip).width(width)
                
                Popper.createPopper(button,tooltip, {
                    placement: 'bottom',
                })
                
                setTimeout(() => {
                    showMoreReload()
                }, 100);
            });
        // Show More Events Open/Close

        // Open Modal
            $('.list ul h5').click(function () {
                openModal('update',this.dataset.id)
                $($(this).parents().get(3)).fadeOut(10)
            })
        // Open Modal

        // Scroll Update
            $('.container').scroll(function() {
                
                showMoreReload()
                
            });
        // Scroll Update
    }
    $('body').on('click', function (e) {
        $('.more-event #btn-show-more').each(function () {
            var tooltip = $(this).siblings().get(0)
            var button = $(this).get(0)
            if ($(tooltip).css('display') == 'block') {

                if ($(e.target).get(0) != button && $(e.target).get(0) != tooltip) { 
                    $(tooltip).fadeOut(100)
                }
            }
        });
        // 
    });
// More Events