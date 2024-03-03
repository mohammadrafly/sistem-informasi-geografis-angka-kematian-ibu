async function Login() {
    const formData = $('#formLogin').serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: BASEURL + 'login',
            method: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                alert(response.message);
                window.location.href = BASEURL + 'dashboard';
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Failed to Login. Please try again later.');
            }
        });
}