let currentPage = 1;
let totalPages = 1;
const itemsPerPage = 10;

$(document).ready(function() {
    fetchData();
});

function fetchData() {
    const searchQuery = $('#table-search').val();
    $.ajax({
        url: BASEURL + 'dashboard/user',
        type: 'GET',
        data: {
            page: currentPage,
            per_page: itemsPerPage,
            search: searchQuery
        },
        success: function(response) {
            populateTable(response.message.data);
            updatePagination(response.message);
        },
        error: function(error) {
            console.error('Error getting user data:', error.responseText);
        }
    });
}

function previousPage() {
    if (currentPage > 1) {
        currentPage--;
        fetchData();
    }
}

function nextPage() {
    if (currentPage < totalPages) {
        currentPage++;
        fetchData();
    }
}

function updatePaginationInfo(currentPage, totalPages, totalItems) {
    $('#pagination-info').html(`Showing <span class="font-semibold text-gray-900">${(currentPage - 1) * itemsPerPage + 1}-${currentPage * itemsPerPage}</span> of <span class="font-semibold text-gray-900">${totalItems}</span>`);
}

function updatePagination(data) {
    const currentPage = data.current_page;
    const totalPages = data.last_page;
    const totalItems = data.total;
    let paginationHTML = '';
    paginationHTML += `<li><a href="#" onclick="previousPage()" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg">Previous</a></li>`;

    for (let i = 1; i <= totalPages; i++) {
        paginationHTML += `<li><a href="#" onclick="changePage(${i})" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 ${currentPage === i ? 'text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700' : ''}">${i}</a></li>`;
    }

    paginationHTML += `<li><a href="#" onclick="nextPage()" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg">Next</a></li>`;

    $('#pagination').html(paginationHTML);
    updatePaginationInfo(currentPage, totalPages, totalItems);
}

function changePage(page) {
    currentPage = page;
    fetchData();
}

$('#table-search').on('input', function() {
    fetchData();
});

function populateTable(response) {
    if (!response) {
        console.error('Invalid response format or missing user data.');
        return;
    }

    var tableBody = $('#userTable tbody');
    tableBody.empty();

    if (!response.length) {
        console.warn('No categories found in the response.');
        return;
    }

    response.forEach(function(user, index) {
        var row = $('<tr>').addClass('bg-white border-b');
        row.append($('<td>').addClass('px-6 py-4').text(index + 1));
        row.append($('<td>').addClass('px-6 py-4').text(user.name));
        row.append($('<td>').addClass('px-6 py-4').text(user.email));
        let roleText = '';
        if (user.role === 'admin') {
            roleText = 'Admin';
        } else if (user.role === 'gizi_dinkes') {
            roleText = 'Gizi Dinkes';
        } else {
            roleText = 'Bidan';
        }
        row.append($('<td>').addClass('px-6 py-4').text(roleText));    
        var editButton = $('<button>')
            .addClass('font-medium text-white bg-blue-600 py-1 px-2 rounded-lg hover:underline')
            .text('Edit')
            .attr('id', 'editButton_' + user.id)
            .click(function() {
                editUser(user.id);
            });
        
        var deleteButton = $('<button>')
            .addClass('ml-2 font-medium text-white bg-red-600 py-1 px-2 rounded-lg hover:underline')
            .text('Delete')
            .attr('id', 'deleteButton_' + user.id)
            .click(function() {
                deleteUser(user.id);
            });
        
        row.append($('<td>').addClass('px-6 py-4').append(editButton).append(deleteButton));

        tableBody.append(row);
    });
}

function saveUser() {
    const id = $('#id').val();
    const formData = $('#userForm').serialize();
    ajaxRequest(`dashboard/user${id ? '/update/' : ''}` + (id ? id : ''), 'POST', formData,
        function(response) {
            console.log(response);
            $('#userForm')[0].reset();
            alert('User saved successfully!');
            fetchData();
        },
        function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Failed to save user. Please try again later.');
        }
    );
}

function editUser(userId) {  
    ajaxRequest('dashboard/user/update/' + userId, 'GET', '',
        function(response) {
            $('#userForm')[0].reset();
            console.log(response);
            toggleCollapse('form');
            $('#id').val(response.message.id);
            $('#name').val(response.message.name);
            $('#email').val(response.message.email);
            $('#role').val(response.message.role).prop('disabled', true);

            $('#password_section').val(response.message.password).prop('hidden', true);
            $('#password_section2').val(response.message.password).prop('hidden', true);
            fetchData();
        },
        function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Failed to save user. Please try again later.');
        }
    );
}

function deleteUser(userId) {
    if (confirm("Are you sure you want to delete this user?")) {
        ajaxRequest('dashboard/user/delete/' + userId, 'GET', null,
            function(response) {
                console.log(response);
                alert('User deleted successfully!');
                fetchData();
            },
            function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Failed to delete user. Please try again later!');
            }
        );
    }
}