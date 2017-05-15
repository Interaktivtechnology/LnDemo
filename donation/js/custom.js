
  $(document).ready(function() {
  $('.custom-select').fancySelect(); // Custom select
  $('[data-toggle="tooltip"]').tooltip() // Tooltip
  $(".numbered").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
             // Allow: Ctrl+C
            (e.keyCode == 67 && e.ctrlKey === true) ||
             // Allow: Ctrl+X
            (e.keyCode == 88 && e.ctrlKey === true) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

  $('#checkbox-lang-1-2').click(function () {

        //check if checkbox is checked
        if ($(this).is(':checked')) {

            //$('#submit').removeAttr('disabled'); //enable input
            $('#myModal').modal('show');
            $(this).removeAttr('checked');

        } else {

            //$('#submit').attr('disabled', true); //disable input
        }
    });
    $('.close').click(function(){
      $( "#message1" ).slideUp();
      return false;
    })
  $('#dob').datepicker({
     dateFormat: 'dd/mm/yy',
     changeMonth: true,
     changeYear: true,
     altField: "#idTourDateDetailsHidden",
     altFormat: "dd/mm/yy",
     yearRange: '-65:', 
     maxDate: '1999/12/31'
  });

    function showMessage(messages){
      $('#warninglist').html(messages);
      $("html, body").animate({ scrollTop: 0 }, "slow");
      $( "#message1" ).slideDown( "slow", function() {
        
        
      });
      return false;
      }

    function closeModal(){
      setTimeout(
      function() 
      {
        $('#myPleaseWait').modal('hide');
      }, 2000);
    }
      
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
    $('#reset').click(function(){
       $('#nationality').val('SG');
       $('#gender').val('');
       $('#id_type').val('nric');
       $('select').change();
  });

    $('#inputFile-2').on('change', function ()
    {
        //$('#inputFile-2').val('aaa');
        var names = new Array();
        for (var i = 0; i < this.files.length; i++)
        {
            names.push(this.files[i].name);
        }
        if(names.length < 2){
          alert(names[0])
          $('#inputFile-2').val(names[0]);
        }
        else{
           $('#inputFile-2').val(names.join());
        }
        $(this).parentNode.parentNode.nextElementSibling.value = 'aaa';
        return false;
    });
    $( "#postcode" ).focusout(function() {
      var postcode = $('#postcode').val();
      if(postcode.length == 6){
        $.ajax({
          method: "POST",
          async:false,
          url: "validate.php?type=postcode",
          data: {  key: postcode  }
        })
        .done(function( data ) {
          if(data != 'none'){
              if( !$('#address1').val() ){
                $('#address1').val(data);
              }
              if( !$('#address2').val() ){
                $('#address2').val(data);
              }
            }
        });
      }
    });

    $('#submit').click(function(){
      $('#myPleaseWait').modal('show');
      var messages = '';
      if( !$('#fullname').val() ) {
        messages += '<li>Fullname must be filled</li>';
      }
      if( !$('#email').val() ) {
        messages += '<li>Email must be filled</li>';
      }
      var $email = $('#email'); 
      var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
      if ($email.val() == '' || !filter.test($email.val()))
      {
          messages += '<li>Email address is not valid</li>';
      }
      if( !$('#dob').val() ) {
        messages += '<li>Date of birth must be filled</li>';
      }
      else{
        var age = 13; 
        var mydate = new Date($("#dob").val());
        mydate.setFullYear(mydate.getFullYear());
        var currdate = new Date();
        currdate.setFullYear(currdate.getFullYear() - age);
        if ((currdate - mydate) < 0){
            messages += '<li>Minimum age is 13 years old </li>';
        }
      }
      if( !$('#gender').val() ) {
        messages += '<li>Gender must be chosen</li>';
      }
      if( !$('#nationality').val() ) {
        messages += '<li>Nationality must be chosen</li>';
      }
      if( !$('#id_no').val() ) {
        messages += '<li>ID No must be filled</li>';
      }

      if( $('#id_no').val() ) {
        var validNRIC = validateNRIC($('#id_no').val());
        if(validNRIC != true){
        messages += '<li>ID No is not valid</li>';
        }
      }
      if( !$('#address1').val() ) {
        messages += '<li>Address 1 must be filled</li>';
      }
      if( !$('#address2').val() ) {
        //messages += '<li>Address 2 must be filled</li>';
      }
      if( !$('#city').val() ) {
        messages += '<li>City must be filled</li>';
      }
      if( !$('#postcode').val() ) {
        messages += '<li>Postal Code must be filled</li>';
      }
      if( !$('#mobile').val() ) {
        messages += '<li>Mobile Phone must be filled</li>';
      }
      if ($('#checkbox-lang-1-2').is(':checked')) {
      }
      else{
        messages += '<li>Agreement need to be checked</li>';
      }
      
      if(messages.length > 1){
      showMessage(messages);
      closeModal();
      return false;
      }
      else{
        $.ajax({
          method: "POST",
          async:false,
          url: "validate?type=nric",
          data: {  key: $('#id_no').val()  }
        })
        .done(function( data ) {
          if(data != 'ok'){
              messages += '<li>ID No is already in use</li>';
            }
        });
        
        $.ajax({
          method: "POST",
          async:false,
          url: "validate?type=email",
          data: {  key: $('#email').val()  }
        })
        .done(function( data ) {
          if(data != 'ok'){
              messages += '<li>This email has already been used. Please use another email.</li>';
            }
        });

        if(messages.length > 1){
          showMessage(messages);
          closeModal();
          $('#myPleaseWait').modal('hide');
          return false;
          }
        closeModal();
        return true;
      }

    })
    $('#race').fancySelect().on('change.fs', function () {
    if(this.value == 'Others (Please Specify)'){
        $('#div_other_race').val('');
        $('#div_other_race').slideDown();
      }
      else{
        $('#div_other_race').slideUp();
      }
    });
    $('#nationality').fancySelect().on('change.fs', function () {
    if(this.value == 'Others (Please Specify)'){
        $('#other_nationality').val('');
        $('#div_other_nationality').slideDown();
      }
      else{
        $('#div_other_nationality').slideUp();
      }
    });
    $('#religion').fancySelect().on('change.fs', function () {
    if(this.value == 'Others (Please Specify)'){
        $('#div_other_religion').val('');
        $('#div_other_religion').slideDown();
      }
      else{
        $('#div_other_religion').slideUp();
      }
    });
    $('#source').fancySelect().on('change.fs', function () {
    if(this.value == 'Other'){
        $('#div_find_other').val('');
        $('#div_find_other').slideDown();
      }
      else{
        $('#div_find_other').slideUp();
      }
    });
    $('.btn-agree').click(function(){
        $('#checkbox-lang-1-2').prop('checked', true);
        //$('#submit').removeAttr('disabled'); //enable input
        //$('#myModal').modal('close');
    })

    $('.sl').change(function () {
            var name = $(this).val();
            var check = $(this).prop('checked');
            if(name == 'other'){
              if( check === true){
                $('#div_sl_other').slideDown();
              }
              else{
                $('#div_sl_other').slideUp();
                $('#other_sl').val('');
              }
            }

        });
    $('.wl').change(function () {
            var name = $(this).val();
            var check = $(this).prop('checked');
            if(name == 'other'){
              if( check === true){
                $('#div_wl_other').slideDown();
              }
              else{
                $('#div_wl_other').slideUp();
                $('#other_wl').val('');
              }
            }

        });
    
});
