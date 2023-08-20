// Live search
$(document).ready(function () {
    let searchInput = document.querySelector('.search-input');
    let tBody = $(".tbody");
    let deleteButton = $(".deleteForm");

    $(searchInput).keyup(function () {
        tBody.html("");

        if (searchInput.value.length > 0) {
            $.ajax({
                type: "GET",
                url: "https://127.0.0.1:8000/api/sub-category",
                data: "v=" + encodeURIComponent(searchInput.value),
                async: false,
                success: function (data) {
                    if (data.length > 0) {
                        for (let i = 0; i < data.length; i++) {
                            let newRow = document.createElement("tr");

                            newRow.innerHTML = `
                                <td class="subCategoriesId">${data[i].id}</td>
                                <td class="subCategoriesName">${data[i].name}</td>
                                <td class="d-flex justify-content-center align-items-center gap-2">
                                    <a href="/admin/sub_category/${data[i].id}"
                                       class="btn btn-warning">Show</a>
                                    <a href="/admin/sub_category/${data[i].id}/edit"
                                       class="custom-btn-edit">Edit</a>
                                </td>
                            `;

                            tBody.append(newRow);
                        }
                        console.log("added");
                    } else {
                        console.log("no data found for this search");
                    }
                }
            });
        }
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


