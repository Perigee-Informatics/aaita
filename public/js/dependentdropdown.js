$(document).ready(function () {
    $.urlParam = function (name) {
        try {

            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            return results[1] || 0;
        } catch {
            return null;
        }
    }
    $('#local_level').append('<option value="">-- select locallevel --</option>');


    $('#province_id').on('change', function () {
        var stateID = $(this).val();
        $('#district_id').append('<option value="">-- Loading...  --</option>');
        if (stateID) {
            $.ajax({
                url: '/district/' + stateID,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (data) {

                    if (data) {
                        $('#district_id').empty();
                        $('#district_id').focus;
                        $('#district_id').append('<option value="">-- Select District  --</option>');
                        var selected_id = $.urlParam("district_id");
                        $.each(data, function (key, value) {
                            var selected = "";
                            if (selected_id == value.id) {
                                selected = "SELECTED";
                            }

                            $('select[name="district_id"]').append('<option class="form-control " value="' + value.id + '" ' + selected + '>' + value.name_en + '</option>');
                            if (selected == "SELECTED") {
                                $("#district_id").trigger("change");
                            }
                        });
                    } else {
                        $('#district_id').empty();

                    }
                }
            });
        } else {
            $('#district_id').empty();
            $('#district_id').append('<option value="" selected disabled>-- Select Province First  --</option>');
        }
    });

    $('#district').on('change', function () {
        var districtID = $(this).val();
        if (districtID) {
            $('#local_level').append('<option value="">-- Loading...  --</option>');
            $.ajax({
                url: '/local_level/' + districtID,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (data) {
                    if (data) {
                        $('#local_level').empty();
                        $('#local_level').focus;
                        $('#local_level').append('<option value="">-- select locallevel --</option>');
                        var selected_id = $.urlParam("local_level");
                        $.each(data, function (key, value) {
                            var selected = "";
                            if (selected_id == value.id) {
                                selected = "SELECTED";
                            }
                            $('select[name="local_level"]').append('<option class="form-control nepali_td" value="' + value.id + '" ' + selected + '>' + value.name_lc + '</option>');
                            if (selected == "SELECTED") {
                                $("#local_level").trigger("change");
                            }
                        });
                    } else {
                        $('#local_level').empty();
                    }
                }
            });
        } else {
            $('#local_level').empty();
        }
    });


    $('#local_level').on('change', function () {
        var projectID = $(this).val();
        if (projectID) {
            $('#project_id').append('<option value="">-- Loading...  --</option>');
            $.ajax({
                url: '/projectid/' + projectID,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (data) {
                    if (data) {
                        $('#project_id').empty();
                        $('#project_id').focus;
                        $('#project_id').append('<option value="">-- परियोजना --</option>');
                        var selected_id = $.urlParam("project_id");
                        $.each(data, function (key, value) {
                            var selected = "";
                            if (selected_id == value.id) {
                                selected = "SELECTED";
                            }
                            $('select[name="project_id"]').append('<option class="form-control nepali_td" value="' + value.id + '" ' + selected + '>' + value.code + '-' + value.name_lc + '-' + value.name_en + '</option>');
                            if (selected == "SELECTED") {
                                $("#project_id").trigger("change");
                            }
                        });
                    } else {
                        $('#project_id').empty();
                    }
                }
            });
        } else {
            $('#project_id').empty();
        }
    });
});


