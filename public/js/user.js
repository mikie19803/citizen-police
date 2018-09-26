/**
 * Created by Vincentia on 17-Sep-17.
 */
var token = $("input[name='_token']").val();

 $('.remove-user').click(function (e) {
     userId = $(this).attr('data-user');
    swal({
        title: 'Are you sure you want to delete this user?',
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
                                 url:'/'+'user/'+userId,
                                 data:{_token:token},
                                 success:function (e) {
                                     swal(
                                         'Deleted!',
                                         'User has been deleted.',
                                         'success'
                                     ).then(function(){
                                         window.location.href = '/user';
                                     })
                                 }
                             });

    })

});