$(document).ready(function () {
    //hide other details from employee form

    $('.searchselect').select2();
    $('.form-group1').hide();
    $('#to-hide').on('click', function () {
        $('.form-group1').toggle();
    });

    NAST.getDistrict();
    NAST.getFedLocalLevel();
});

let NAST = {
    
    getDistrict: () => {
        $.urlParam = function (name) {
            try {
    
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                return results[1] || 0;
            } catch {
                return null;
            }
        }
        var state_id = $('#filter_provinceId').val();
        $('#filter_districtId').append('<option value="">-- Loading...  --</option>');

        //first remove district and client params on change
        $('#filter_districtId').val('').trigger('change');
        $('#filter_client').val('').trigger('change');

        if (state_id) {
            $.ajax({
                url: '/district/' + state_id,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (data) {

                    if (data) {
                        $('#filter_districtId').empty();
                        $('#filter_districtId').focus;
                        $('#filter_districtId').append('<option value="">-- select district --</option>');
                        var selected_id = $.urlParam("district_id");
                        $.each(data, function (key, value) {
                            var selected = "";
                            if (selected_id == value.id) {
                                selected = "SELECTED";
                            }

                            $('select[name="filter_districtId"]').append('<option class="form-control nepali_td" value="' + value.id + '" ' + selected + '>' + value.code + ' - ' + value.name_en +  '</option>');
                            if (selected == "SELECTED") {
                                $("#filter_districtId").trigger("change");
                            }
                        });
                    } else {
                        $('#filter_districtId').empty();

                    }
                }
            });
        } else {
            $('#filter_districtId').empty();
        }
    },


    
    getFedLocalLevel: () => {
        $.urlParam = function (name) {
            try {
    
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                return results[1] || 0;
            } catch {
                return null;
            }
        }

        var district_id = $('#filter_districtId').val();

        //first remove client params on change
        $('#filter_client').val('').trigger('change');

        if (district_id) {
            $('#filter_client').append('<option value="">-- Loading...  --</option>');
            $.ajax({
                url: '/local_level/' + district_id,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (data) {
                    if (data) {
                        $('#filter_client').empty();
                        $('#filter_client').focus;
                        $('#filter_client').append('<option value="">-- select local level --</option>');
                        var selected_id = $.urlParam("client");
                        $.each(data, function (key, value) {
                            var selected = "";
                            if (selected_id == value.id) {
                                selected = "SELECTED";
                            }
                            $('select[name="filter_client"]').append('<option class="form-control nepali_td" value="' + value.id + '" ' + selected + '>' + value.code + ' - ' + value.name_en +  '</option>');
                            if (selected == "SELECTED") {
                                $("#filter_client").trigger("change");
                            }
                        });
                    } else {
                        $('#filter_client').empty();
                    }
                }
            });
        } else {
            $('#filter_client').empty();
        }
    }

    

}
window.NAST = NAST;
