
jQuery(document).ready(function() {
    
    /*
        Fullscreen background
    */
    $.backstretch("assets/img/bg-inner.jpg");
    
    $('#top-navbar-1').on('shown.bs.collapse', function(){
        $.backstretch("resize");
    });
    $('#top-navbar-1').on('hidden.bs.collapse', function(){
        $.backstretch("resize");
    });
    
    /*
        Form
    */
    $('.registration-form fieldset:first-child').fadeIn('slow');
    
    $('.registration-form input[type="text"], .registration-form input[type="password"], .registration-form textarea').on('focus', function() {
        $(this).removeClass('input-error');
    });
    
    // next step
    $('.registration-form .btn-next').on('click', function() {
        var parent_fieldset = $(this).parents('fieldset');
        var next_step = true;
        
        parent_fieldset.find('input[type="text"], input[type="password"], textarea').each(function() {
            if( $(this).val() == "" ) {
                $(this).addClass('input-error');
                next_step = false;
            }
            else {
                $(this).removeClass('input-error');
            }
        });
        
        if( next_step ) {
            parent_fieldset.fadeOut(400, function() {
                $(this).next().fadeIn();
            });
        }
        
    });

    function validateNRIC(str) {
      if (str.length != 9) 
          return false;

      str = str.toUpperCase();

      var i, 
          icArray = [];
      for(i = 0; i < 9; i++) {
          icArray[i] = str.charAt(i);
      }

      icArray[1] = parseInt(icArray[1], 10) * 2;
      icArray[2] = parseInt(icArray[2], 10) * 7;
      icArray[3] = parseInt(icArray[3], 10) * 6;
      icArray[4] = parseInt(icArray[4], 10) * 5;
      icArray[5] = parseInt(icArray[5], 10) * 4;
      icArray[6] = parseInt(icArray[6], 10) * 3;
      icArray[7] = parseInt(icArray[7], 10) * 2;

      var weight = 0;
      for(i = 1; i < 8; i++) {
          weight += icArray[i];
      }

      var offset = (icArray[0] == "T" || icArray[0] == "G") ? 4:0;
      var temp = (offset + weight) % 11;

      var st = ["J","Z","I","H","G","F","E","D","C","B","A"];
      var fg = ["X","W","U","T","R","Q","P","N","M","L","K"];

      var theAlpha;
      if (icArray[0] == "S" || icArray[0] == "T") { theAlpha = st[temp]; }
      else if (icArray[0] == "F" || icArray[0] == "G") { theAlpha = fg[temp]; }

      return (icArray[8] === theAlpha);
    }
    
    // previous step
    $('.registration-form .btn-previous').on('click', function() {
        $(this).parents('fieldset').fadeOut(400, function() {
            $(this).prev().fadeIn();
        });
    });

    $('#btn-volunteer').on('click',function(e){
        if($('.right2').hasClass('dimmer')){
            $('.ibtn').removeClass('dimmer2');
            $('.devRight').removeClass('dimmer');
            $('#inputvolunteer').val('1');
        }
        else{
            $('.ibtn').addClass('dimmer2');
            $('#inputvolunteer').val('');
            $('.right2').addClass('dimmer');
        }
    })

    $('#inputvolunteer').val('');
    $('#inputmember').val('1');
    
    $('#submit').on('click',function(e){
        $('#inputmember').val('1');
        if( $('#form-nric').val() ) {
            var validNRIC = validateNRIC($('#form-nric').val());
            if(validNRIC != true){
            alert('NRIC is invalid');
            return false;
            }
          }
          else{
            alert('NRIC is required');
            return false;
          }
        /*
        if ($("#btn-member").hasClass("btn-top-active")) {
            $('#inputmember').val('1');
        }
        else{
            $('#inputmember').val('');
        }
        /*
        if ($("#btn-volunteer").hasClass("btn-top-active")) {
            $('#inputvolunteer').val('1');
        }
        else{
            $('#inputvolunteer').val('');
        }
        */
        var error = 'success';
        $('.registration-form').find('.required').each(function() {
            if( $(this).val() == "" ) {
                //alert($(this).attr('id'));
                e.preventDefault();
                $(this).addClass('input-error');
                var error = 'error';
            }
            else {
                $(this).removeClass('input-error');
                //$('.registration-form').submit();
            }
        });
        if(error == 'success'){
             $('.registration-form').submit();
        }
        else{
            alert('Error found');
        }
    })
    $( "#form-via" ).change(function() {
        if(this.value == '8'){
            $('#specify').val('');
            $('#specify').slideDown();
          }
          else{
            $('#specify').slideUp();
          }
    });
    $('.tos').click(function () {
        $('#myModal').modal('show');
        return false;
    });
    $('.btn-agree').click(function(){
        //$('#agree').prop('checked', true);
    })
    
    $('.btn-top').click(function(){
        $(this).toggleClass('btn-top-active');
    })    
    $('#race').on('change', function() {
    if(this.value == 'Yes'){
        $('#div_other_race').val('');
        $('#div_other_race').slideDown();
      }
      else{
        $('#div_other_race').slideUp();
      }
    });
    $('#race2').on('change', function() {
    if(this.value == 'Yes'){
        $('#div_other_race2').val('');
        $('#div_other_race2').slideDown();
      }
      else{
        $('#div_other_race2').slideUp();
      }
    });

    $('#form-birth-year').datepicker({
     dateFormat: 'dd/mm/yy',
     changeMonth: true,
     changeYear: true,
     altField: "#idTourDateDetailsHidden",
     altFormat: "dd/mm/yy",
     yearRange: '-65:', 
     maxDate: '1999/12/31'
    });

    $('#diag').change(function () {
            var name = $(this).val();
            var check = $(this).prop('checked');
            if(name == 'diag'){
              if( check === true){
                $('#cancer').slideDown();
              }
              else{
                $('#cancer').slideUp();
              }
            }

        });
});
