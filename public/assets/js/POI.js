let currentPage = 1;
let totalPages = 1;
const itemsPerPage = 10;

$(document).ready(function() {
    fetchData();
});

function fetchData() {
    const searchQuery = $('#table-search').val();
    $.ajax({
        url: BASEURL + 'dashboard/poi',
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
            console.error('Error getting poi data:', error.responseText);
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
        console.error('Invalid response format or missing poi data.');
        return;
    }

    var tableBody = $('#poiTable tbody');
    tableBody.empty();

    if (!response.length) {
        console.warn('No categories found in the response.');
        return;
    }

    response.forEach(function(poi, index) {
        var row = $('<tr>').addClass('bg-white border-b');
        row.append($('<td>').addClass('px-6 py-4').text(index + 1));
        row.append($('<td>').addClass('px-6 py-4').text(poi.nama_titik));
        row.append($('<td>').addClass('px-6 py-4').text(poi.alamat));
        row.append($('<td>').addClass('px-6 py-4').text(poi.geojson));
        row.append($('<td>').addClass('px-6 py-4').text(poi.nama_kategori));  
        row.append($('<td>').addClass('px-6 py-4').text(poi.warna));
        var editButton = $('<button>')
            .addClass('font-medium text-white bg-blue-600 py-1 px-2 rounded-lg hover:underline')
            .text('Edit')
            .attr('id', 'editButton_' + poi.id)
            .click(function() {
                editPoi(poi.id);
            });
        
        var deleteButton = $('<button>')
            .addClass('ml-2 font-medium text-white bg-red-600 py-1 px-2 rounded-lg hover:underline')
            .text('Delete')
            .attr('id', 'deleteButton_' + poi.id)
            .click(function() {
                deletePoi(poi.id);
            });
        
        row.append($('<td>').addClass('px-6 py-4').append(editButton).append(deleteButton));

        tableBody.append(row);
    });
}

function savePoi() {
        const id = $('#id').val();
        const formData = new FormData($('#poiForm')[0]);
        $.ajax({
            url: BASEURL + `dashboard/poi${id ? '/update/' + id : ''}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                $('#poiForm')[0].reset();
                alert('Poi saved successfully!');
                fetchData();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Failed to save poi. Please try again later.');
            }
        });
    }

function editPoi(poiId) {  
    ajaxRequest('dashboard/poi/update/' + poiId, 'GET', '',
        function(response) {
            $('#poiForm')[0].reset();
            console.log(response);
            toggleCollapse('form');
            $('#id').val(response.message.id);
            $('#nama_titik').val(response.message.nama_titik);
            const kasusData = [
                {'id': response.message.kasus.id, 'alamat': response.message.kasus.alamat} 
            ];
            const selectElement = document.getElementById('id_kasus');
            kasusData.forEach(function(kasus) {
                const option = document.createElement('option');
                option.value = kasus.id;
                option.textContent = kasus.alamat;
                selectElement.appendChild(option);
            });
            $('#id_kasus').val(response.message.id_kasus);
            $('#geojson').attr('src',response.message.geojson);
            $('#id_category').val(response.message.id_category);
            $('#warna').val(response.message.warna);
            fetchData();
        },
        function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Failed to save poi. Please try again later.');
        }
    );
}

function deletePoi(poiId) {
    if (confirm("Are you sure you want to delete this poi?")) {
        ajaxRequest('dashboard/poi/delete/' + poiId, 'GET', null,
            function(response) {
                console.log(response);
                alert('Poi deleted successfully!');
                fetchData();
            },
            function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Failed to delete poi. Please try again later!');
            }
        );
    }
}
