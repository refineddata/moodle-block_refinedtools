$(document).ready(function() {
    $('#Link-Form').hide();
    $('#Datatables-Users').dataTable( {
        "ajax": "ajax/userlist.php",
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true
    } );
    $('#Datatables-Events').dataTable( {
        "ajax": "ajax/eventlist.php",
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true
    } );
    
    $('#Datatables-Users').on( 'click', 'tr', function () {
        var table = $('#Datatables-Users').DataTable();
        var userid = table.cell( this, 0 ).data();

        if( userid ){
            $('#selected-user').val( userid );

            $('#User-Selection-List').hide(1500);
            $('#Event-Selection-List').show(1500);
        }
    });

    $('#backtouserlist').click(function(){
        $('#selected-user').val( 0 );

        $('#User-Selection-List').show(1500);
        $('#Event-Selection-List').hide(1500);
    });
    
    $('#Datatables-Events').on( 'click', 'tr', function () {
        var table = $('#Datatables-Events').DataTable();
        var eventid = table.cell( this, 0 ).data();

        if( eventid ){
            $('#selected-event').val( eventid );
    
            doLinkFormContent();

            $('#Event-Selection-List').hide(1500);
            $('#Link-Form').show(1500);
        }
    });
    
    $('#backtoeventlist').click(function(){
        $('#selected-event').val( 0 );

        $('#Event-Selection-List').show(1500);
        $('#Link-Form').hide(1500);
    });

    $(document).on( 'click', '#enrol-current-user', function(){
//    $('#enrol-current_user').click(function(){
        var vars = {}; 
        vars['userid'] = $('#selected-user').val();
        vars['eventid'] = $('#selected-event').val();

        $.ajax({
            type: 'GET',
            url: 'ajax/enrol_user.php',
            data: vars,
            success: function (data) {
                $('#Link-Form').hide(1500);
                setTimeout(doLinkFormContent, 1500);
                $('#Link-Form').show(1500);
            }
        });
    });
    
    $('#backtolinkform').click(function(){
        $('#Complete-No-Reminder').hide(1500);
        $('#Link-Form').show(1500);
    });

    $(document).on( 'click', '#send-event-reminder', function(){
        var vars = {}; 
        vars['userid'] = $('#selected-user').val();
        vars['eventid'] = $('#selected-event').val();
        
        $('#Link-Form').hide(1500);

        $.ajax({
            type: 'GET',
            url: 'ajax/send_message.php',
            data: vars,
            success: function (data) {
                //$('#Link-Form').hide(1500);
                if( data.error ){
                    if( data.error == 'nouser' ){
                        $('#User-Selection-List').show(1500);
                    }
                    if( data.error == 'noevent' ){
                        $('#Event-Selection-List').show(1500);
                    }
                    if( data.error == 'noreminder' ){
                        $('#Complete-No-Reminder').show(1500);
                    }
                }else{
                    $('#Complete-Sending').show(1500);
                }
            }
        });
    });

    $(document).on( 'click', '#reset-page', function(){
        $('#selected-event').val( 0 );
        $('#selected-user').val( 0 );
        
        $('#Complete-Sending').hide(1500);
        $('#User-Selection-List').show(1500);
    });

    function doLinkFormContent(){
        var vars = {}; 
        vars['userid'] = $('#selected-user').val();
        vars['eventid'] = $('#selected-event').val();

        $.ajax({
            type: 'GET',
            url: 'ajax/link_form_content.php',
            data: vars,
            success: function (data) {
                if( data.error ){
                    if( data.error == 'nouser' ){
                        $('#Event-Selection-List').hide(1500);
                        $('#Link-Form').hide(1500);
                        $('#User-Selection-List').show(1500);
                    }
                    if( data.error == 'noevent' ){
                        $('#User-Selection-List').hide(1500);
                        $('#Link-Form').hide(1500);
                        $('#Event-Selection-List').show(1500);
                    }
                }else{
                    $('#Link-Form-Content').html( data.content );
                }
            }
        });
    }

} );
