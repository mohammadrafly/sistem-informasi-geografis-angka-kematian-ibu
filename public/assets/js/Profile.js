$(document).ready(function() {
    profile();
});

function profile() {
    const id = $('#id').val();   
    $.ajax({
        url: BASEURL + 'dashboard/profile/' + id,
        type: 'GET',
        success: function(response) {
            $('#name').val(response.message.name);
            $('#email').val(response.message.email);
            $('#role').val(response.message.role);
        },
        error: function(error) {
            console.error('Error getting profile:', error.responseText);
        }
    });
}

function updateProfile() {
    const id = $('#id').val();   
    const formData = $('#profileForm').serialize();
    ajaxRequest('dashboard/profile/' + id, 'POST', formData,
        function(response) {
            alert(response.message);
        },
        function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Failed to save profile. Please try again later.');
        }
    );
}

function updatePassword() {
    const id = $('#id').val();   
    const formData = $('#passwordForm').serialize();
    ajaxRequest('dashboard/profile/password/' + id, 'POST', formData,
        function(response) {
            alert(response.message);
        },
        function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Failed to save password. Please try again later.');
        }
    );
}