// Live search

$(document).ready(function () {
    let searchInput = document.querySelector('.search-input');
    $(searchInput).keyup(function () {
        console.log(searchInput.value);

        if(searchInput.value.length > 0){

        }$.ajax({
            type:"GET",
            url: "https://127.0.0.1:8000/admin/sub_category/",
            data : "v=" + encodeURIComponent(searchInput.value),
            success: function (data){
                if(data.length > 0) {
                    console.log(data);
                }else{
                    console.log("no data found for this search");
                }
            }
        })
    });
});

    //         $('.searchresult').html('');
    //         var input_user = $(this).val();
    //
    //         if (input_user.length > 0)
    //
    //             $.ajax({
    //                 type: "GET",
    //                 url: "search.php",
    //                 data: "input=" + encodeURIComponent(input_user),
    //                 success: function (data) {
    //                     if (data.length > 0) {
    //                         $('.searchresult').append(data);
    //
    //                         // }else{
    //                         //     $('.searchresult').append("Pas de suggestions");
    //
    //
    //                     }
    //                 }
    //             })
    //     })
    //


