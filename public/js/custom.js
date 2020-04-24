$(document).ready(function() {
    var max_fields = 10; //Maximum allowed input fields 
    var wrapper    = $(".wrapper"); //Input fields wrapper
    var add_button = $(".add_fields"); //Add button class or ID
    var x = 1; //Initial input field is set to 1
 
 //When user click on add input button
 $(add_button).click(function(e){
        e.preventDefault();
 //Check maximum allowed input fields
        if(x < max_fields){ 
            x++; //input field increment
 //add input field
            $(wrapper).append('<div><input id="skill" type="text" class="form-control mt-2" name="skill[]" required autocomplete="skill" /> <a href="javascript:void(0);" class="remove_field">Remove</a></div>');
        }
    });
 
    //when user click on remove button
    $(wrapper).on("click",".remove_field", function(e){ 
        e.preventDefault();
 $(this).parent('div').remove(); //remove inout field
 x--; //inout field decrement
    })
});