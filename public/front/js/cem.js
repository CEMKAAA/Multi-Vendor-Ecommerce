$(document).ready(function() {

    $('#quick-look').hide();

    // Handle change event of the select box
    $('#show-records').change(function() {
        var selectedValue = $(this).val();
        var selectedValue_2 = $('#sort-by').val();
        var url = $(this).attr('url');

        console.log(url);

        // Make an AJAX request to fetch the paginated data
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/' + url,
            data: { value: selectedValue, value_2: selectedValue_2 },
            success: function(resp) {
                // Update the content of the product listing section
                $('#product-listing').html(resp);
            },
            error: function() {
                alert("Error");
            }
        });
    });


    // Handle change event of the select box
    $('#sort-by').change(function() {
        var selectedValue = $(this).val(); // Get the selected value
        var selectedValue_2 = $('#show-records').val()
        var url = $(this).attr('url');

        console.log(url,selectedValue);

        // Make an AJAX request to fetch the paginated data
        $.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'POST',
			url:'/'+url,
			data:{ value_2: selectedValue, value: selectedValue_2 },
			success:function(resp){
                //update it
                $('#product-listing').html(resp);
			},error:function(){
				alert("Error");
			}
		})
    });

    $(document).on('click', '#goruntule', function() {
    var productId = $(this).data('product-id');

    console.log(productId);

    // Make an AJAX request to fetch the required information
    $.ajax({
        url: '/quick-view/'+productId,
        type: 'GET',
        success: function(response) {
            $('#quick-look').html(response);

            $("#quick-view").css("display", "flex");
            $("#quick-look").css("display", "flex");

            // Show the #quick-look element
            $('#quick-look').show();
        },
        error: function() {
            // Handle error case
            console.log('Error fetching product information');
        }
    });
    });

    $(document).on('click', '#close_quick', function() {

        $("#quick-view").css("display", "none");
        $("#quick-look").css("display", "none");
        $('#quick-look').hide()

    });

});









