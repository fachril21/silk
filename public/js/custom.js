$(document).ready(function() {
    var max_fields = 10; //Maximum allowed input fields
    var wrapper = $(".wrapper"); //Input fields wrapper
    var add_button = $(".add_fields"); //Add button class or ID
    var x = 1; //Initial input field is set to 1

    //When user click on add input button
    $(add_button).click(function(e) {
        e.preventDefault();
        //Check maximum allowed input fields
        if (x < max_fields) {
            x++; //input field increment
            //add input field
            $(wrapper).append(
                '<div><input id="skill" list="dataKeahlian" type="text" class="form-control mt-2" name="skill[]" required autocomplete="skill" /><datalist id="dataKeahlian"> @foreach($dataKeahlian as $row) <option value="{{$row->skill}}"> @endforeach  </datalist> <a href="javascript:void(0);" class="remove_field">Remove</a></div>'
            );
        }
    });

    //when user click on remove button
    $(wrapper).on("click", ".remove_field", function(e) {
        e.preventDefault();
        $(this)
            .parent("div")
            .remove(); //remove inout field
        x--; //inout field decrement
    });
});

$(function() {
    var max_fields = 10; //Maximum allowed input fields
    var wrapper = $(".wrapper_achievment"); //Input fields wrapper
    var add_button = $(".add_fields_ach"); //Add button class or ID
    var x = 1; //Initial input field is set to 1

    //When user click on add input button
    $(add_button).click(function(e) {
        e.preventDefault();
        //Check maximum allowed input fields
        if (x < max_fields) {
            x++; //input field increment
            //add input field
            $(wrapper).append(
                '<div><input id="achievment" type="text" class="form-control mt-2" name="achievment[]" required autocomplete="achievment" /> <a href="javascript:void(0);" class="remove_field">Remove</a></div>'
            );
        }
    });

    //when user click on remove button
    $(wrapper).on("click", ".remove_field", function(e) {
        e.preventDefault();
        $(this)
            .parent("div")
            .remove(); //remove inout field
        x--; //inout field decrement
    });
});

$(function() {
    var max_fields = 10; //Maximum allowed input fields
    var wrapper = $(".wrapper_updateSkill"); //Input fields wrapper
    var add_button = $(".add_fields_updateSkill"); //Add button class or ID
    var x = 1; //Initial input field is set to 1

    //When user click on add input button
    $(add_button).click(function(e) {
        e.preventDefault();
        //Check maximum allowed input fields
        if (x < max_fields) {
            x++; //input field increment
            //add input field
            $(wrapper).append(
                '<div><input id="newSkill" type="text" class="form-control mt-2" name="newSkill[]" required autocomplete="newSkill" /> <a href="javascript:void(0);" class="remove_field">Remove</a></div>'
            );
        }
    });

    //when user click on remove button
    $(wrapper).on("click", ".remove_field", function(e) {
        e.preventDefault();
        $(this)
            .parent("div")
            .remove(); //remove inout field
        x--; //inout field decrement
    });
});

$(function() {
    var max_fields = 10; //Maximum allowed input fields
    var wrapper = $(".wrapper_updateAch"); //Input fields wrapper
    var add_button = $(".add_fields_updateAch"); //Add button class or ID
    var x = 1; //Initial input field is set to 1

    //When user click on add input button
    $(add_button).click(function(e) {
        e.preventDefault();
        //Check maximum allowed input fields
        if (x < max_fields) {
            x++; //input field increment
            //add input field
            $(wrapper).append(
                '<div><input id="newAchievment" type="text" class="form-control mt-2" name="newAchievment[]" required autocomplete="newAchievment" /> <a href="javascript:void(0);" class="remove_field">Remove</a></div>'
            );
        }
    });

    //when user click on remove button
    $(wrapper).on("click", ".remove_field", function(e) {
        e.preventDefault();
        $(this)
            .parent("div")
            .remove(); //remove inout field
        x--; //inout field decrement
    });
});

$(function() {
    var max_fields = 10; //Maximum allowed input fields
    var wrapper = $(".wrapper_skillPengajuan"); //Input fields wrapper
    var add_button = $(".add_fields_skillPengajuan"); //Add button class or ID
    var x = 1; //Initial input field is set to 1

    //When user click on add input button
    $(add_button).click(function(e) {
        e.preventDefault();
        //Check maximum allowed input fields
        if (x < max_fields) {
            x++; //input field increment
            //add input field
            $(wrapper).append(
                '<div><input id="skill" list="dataKeahlian" type="text" class="form-control mt-2" name="skill[]" required autocomplete="skill" /><datalist id="dataKeahlian"> @foreach($dataKeahlian as $row) <option value="{{$row->skill}}"> @endforeach  </datalist> <a href="javascript:void(0);" class="remove_field">Remove</a></div>'
            );
        }
    });

    //when user click on remove button
    $(wrapper).on("click", ".remove_field", function(e) {
        e.preventDefault();
        $(this)
            .parent("div")
            .remove(); //remove inout field
        x--; //inout field decrement
    });
});

$(function() {
    var max_fields = 10; //Maximum allowed input fields
    var wrapper = $(".wrapper_lulusanPelamar"); //Input fields wrapper
    var add_button = $(".add_fields_lulusanPelamar"); //Add button class or ID
    var x = 1; //Initial input field is set to 1

    //When user click on add input button
    $(add_button).click(function(e) {
        e.preventDefault();
        //Check maximum allowed input fields
        if (x < max_fields) {
            x++; //input field increment
            //add input field
            $(wrapper).append(
                '<div><input id="lulusanPelamar" list="dataJurusan" type="text" class="form-control mt-2" name="lulusanPelamar[]" required autocomplete="lulusanPelamar" /><datalist id="dataJurusan"> @foreach($dataJurusan as $row) <option value="{{$row->jurusan}}"> @endforeach  </datalist> <a href="javascript:void(0);" class="remove_field">Remove</a></div>'
            );
        }
    });

    //when user click on remove button
    $(wrapper).on("click", ".remove_field", function(e) {
        e.preventDefault();
        $(this)
            .parent("div")
            .remove(); //remove inout field
        x--; //inout field decrement
    });
});
