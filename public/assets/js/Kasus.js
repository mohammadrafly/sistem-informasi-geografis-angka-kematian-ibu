let currentPage = 1;
let totalPages = 1;
const itemsPerPage = 10;

$(document).ready(function() {
    fetchData();
});

function fetchData() {
    const searchQuery = $('#table-search').val();
    $.ajax({
        url: BASEURL + 'dashboard/kasus',
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
            console.error('Error getting kasus data:', error.responseText);
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
        console.error('Invalid response format or missing kasus data.');
        return;
    }

    var tableBody = $('#kasusTable tbody');
    tableBody.empty();

    if (!response.length) {
        console.warn('No categories found in the response.');
        return;
    }

    response.forEach(function(kasus, index) {
        console.log(kasus)
        var row = $('<tr>').addClass('bg-white border-b');
        row.append($('<td>').addClass('px-6 py-4').text(index + 1));
        row.append($('<td>').addClass('px-6 py-4').text(kasus.alamat));
        row.append($('<td>').addClass('px-6 py-4').text(kasus.usia_ibu));
        row.append($('<td>').addClass('px-6 py-4').text(kasus.tanggal));
        row.append($('<td>').addClass('px-6 py-4').text(kasus.nama_kategori));  
        row.append($('<td>').addClass('px-6 py-4').text(kasus.bukti_kematian));   
        row.append($('<td>').addClass('px-6 py-4').text(kasus.tempat_kematian));
        row.append($('<td>').addClass('px-6 py-4').text(kasus.estafet_rujukan));
        row.append($('<td>').addClass('px-6 py-4').text(kasus.alur));
        row.append($('<td>').addClass('px-6 py-4').text(kasus.masa_kematian));
        row.append($('<td>').addClass('px-6 py-4').text(kasus.hari_kematian));
        var editButton = $('<button>')
            .addClass('font-medium text-white bg-blue-600 py-1 px-2 rounded-lg hover:underline')
            .text('Edit')
            .attr('id', 'editButton_' + kasus.id)
            .click(function() {
                editKasus(kasus.id);
            });
        
        var deleteButton = $('<button>')
            .addClass('ml-2 font-medium text-white bg-red-600 py-1 px-2 rounded-lg hover:underline')
            .text('Delete')
            .attr('id', 'deleteButton_' + kasus.id)
            .click(function() {
                deleteKasus(kasus.id);
            });
        
        row.append($('<td>').addClass('px-6 py-4').append(editButton).append(deleteButton));

        tableBody.append(row);
    });
}

function saveKasus() {
        const id = $('#id').val();
        const formData = new FormData($('#kasusForm')[0]);

        $.ajax({
            url: BASEURL + `dashboard/kasus${id ? '/update/' + id : ''}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                $('#kasusForm')[0].reset();
                alert('Kasus saved successfully!');
                fetchData();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Failed to save kasus. Please try again later.');
            }
        });
    }

function editKasus(kasusId) {
    ajaxRequest('dashboard/kasus/update/' + kasusId, 'GET', '',
        function(response) {
            console.log(response);
            if (response && response.message) {
                $('#kasusForm')[0].reset();
                toggleCollapse('form');
                $('#id').val(response.message.id);
                $('#alamat').val(response.message.alamat);
                $('#usia_ibu').val(response.message.usia_ibu);
                $('#tanggal').val(response.message.tanggal);
                $('#id_category').val(response.message.id_category);
                $('#bukti_kematian').attr('src', response.message.bukti_kematian);
                $('#tempat_kematian').val(response.message.tempat_kematian);
                $('#estafet_rujukan').val(response.message.estafet_rujukan);
                $('#alur').val(response.message.alur);
                $('#masa_kematian').val(response.message.masa_kematian);
                $('#hari_kematian').val(response.message.hari_kematian);
            
                fetchData();
            } else {
                console.error('Invalid response format:', response);
                alert('Failed to fetch kasus details. Please try again later.');
            }
        },
        function(xhr, status, error) {
            console.error('AJAX error:', error);
            alert('Failed to fetch kasus details. Please try again later.');
        }
    );
}

function deleteKasus(kasusId) {
    if (confirm("Are you sure you want to delete this kasus?")) {
        ajaxRequest('dashboard/kasus/delete/' + kasusId, 'GET', null,
            function(response) {
                console.log(response);
                alert('Kasus deleted successfully!');
                fetchData();
            },
            function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Failed to delete kasus. Please try again later!');
            }
        );
    }
}