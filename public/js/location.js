/**
 * Created by Vincentia on 17-Sep-17.
 */
var token = $("input[name='_token']").val();

 $('.remove-location').click(function (e) {
     locationId = $(this).attr('data-location');
    swal({
        title: 'Are you sure you want to delete this location?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function () {
         $.ajax({
                                 type:"delete",
                                 url:'/'+'location/'+locationId,
                                 data:{_token:token},
                                 success:function (e) {
                                     swal(
                                         'Deleted!',
                                         'Location has been deleted.',
                                         'success'
                                     ).then(function(){
                                         window.location.href = '/location';
                                     })
                                 }
                             });

    })

});