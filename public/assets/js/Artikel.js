tinymce.init({
    selector: '#description',
    plugins: '',
    toolbar: '',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
  });

let currentPage = 1;
let totalPages = 1;
const itemsPerPage = 10;

$(document).ready(function() {
fetchData();
});

function fetchData() {
const searchQuery = $('#table-search').val();
$.ajax({
    url: BASEURL + 'dashboard/artikel',
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
        console.error('Error getting artikel data:', error.responseText);
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
    console.error('Invalid response format or missing artikel data.');
    return;
}

var tableBody = $('#artikelTable tbody');
tableBody.empty();

if (!response.length) {
    console.warn('No categories found in the response.');
    return;
}

response.forEach(function(artikel, index) {
    var row = $('<tr>').addClass('bg-white border-b');
    row.append($('<td>').addClass('px-6 py-4').text(index + 1));
    row.append($('<td>').addClass('px-6 py-4').text(artikel.title));
    row.append($('<td>').addClass('px-6 py-4').text(artikel.author_name));
    row.append($('<td>').addClass('px-6 py-4').text(artikel.description.substring(0, 10) + (artikel.description.length > 10 ? '...' : '')));
    row.append($('<td>').addClass('px-6 py-4').text(artikel.category));  
    row.append($('<td>').addClass('px-6 py-4').html(`<img src="${BASEURL}imgs/${artikel.img}" alt="Article Image">`));
    let publishedText = '';
    if (artikel.published === '1') {
        publishedText = 'Published'
    } else {
        publishedText = 'Unpublished'
    }
    row.append($('<td>').addClass('px-6 py-4').text(publishedText));
    var editButton = $('<button>')
        .addClass('font-medium text-white bg-blue-600 py-1 px-2 rounded-lg hover:underline')
        .text('Edit')
        .attr('id', 'editButton_' + artikel.id)
        .click(function() {
            editArtikel(artikel.id);
        });
    
    var deleteButton = $('<button>')
        .addClass('ml-2 font-medium text-white bg-red-600 py-1 px-2 rounded-lg hover:underline')
        .text('Delete')
        .attr('id', 'deleteButton_' + artikel.id)
        .click(function() {
            deleteArtikel(artikel.id);
        });
    
    row.append($('<td>').addClass('px-6 py-4').append(editButton).append(deleteButton));

    tableBody.append(row);
});
}

function saveArtikel() {
    const id = $('#id').val();
    const formData = new FormData($('#artikelForm')[0]);
    const description = tinymce.get('description').getContent();
    formData.append('description', description);

    $.ajax({
        url: BASEURL + `dashboard/artikel${id ? '/update/' + id : ''}`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);
            $('#artikelForm')[0].reset();
            alert('Artikel saved successfully!');
            fetchData();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Failed to save artikel. Please try again later.');
        }
    });
}

function editArtikel(artikelId) {
ajaxRequest('dashboard/artikel/update/' + artikelId, 'GET', '',
    function(response) {
        console.log(response);
        if (response && response.message) {
            $('#artikelForm')[0].reset();
            toggleCollapse('form');
            $('#id').val(response.message.id);
            $('#title').val(response.message.title);
            $('#category').val(response.message.category);
            $('#author').val(response.message.author);
            $('#published').val(response.message.published);
            
            $('#imgPreview').attr('src', response.message.img);
            
            tinymce.get('description').setContent(response.message.description);

            fetchData();
        } else {
            console.error('Invalid response format:', response);
            alert('Failed to fetch artikel details. Please try again later.');
        }
    },
    function(xhr, status, error) {
        console.error('AJAX error:', error);
        alert('Failed to fetch artikel details. Please try again later.');
    }
);
}

function deleteArtikel(artikelId) {
if (confirm("Are you sure you want to delete this artikel?")) {
    ajaxRequest('dashboard/artikel/delete/' + artikelId, 'GET', null,
        function(response) {
            console.log(response);
            alert('Artikel deleted successfully!');
            fetchData();
        },
        function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Failed to delete artikel. Please try again later!');
        }
    );
}
}
