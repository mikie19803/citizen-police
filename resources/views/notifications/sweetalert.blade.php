<script>

    @if(Session::has('success'))
swal(
        '',
        '{{Session::get('success')}}',
        'success'
    );
    @endif
    @if(Session::has('information'))
swal(
        '',
        '{{Session::get('information')}}',
        'information'
    );
    @endif
    @if(Session::has('error'))
swal(
        '',
        '{{Session::get('error')}}',
        'error'
    );
    @endif
    @if(Session::has('warning'))
swal(
        '',
        '{{Session::get('warning')}}',
        'warning'
    );
    @endif
</script>