const BASEURL = 'http://127.0.0.1:8000/';

function ajaxRequest(url, method, data, successCallback, errorCallback) {
    if (typeof data === '') {
      data = null;
    }
  
    $.ajax({
      url: BASEURL + url,
      method: method,
      data: data,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: successCallback,
      error: errorCallback
    });
}

async function Logout() {
    try {
        const response = await $.ajax({
            type: 'GET',
            url: BASEURL + 'dashboard/logout',
            dataType: 'json'
        });

        if (response.success) {
            window.location.href = BASEURL + 'login';
        } else {
            alert(response.message);
        }
    } catch (error) {
        console.error(error);
    }
}

const sidebar = document.getElementById("sidebar");
const toggleButton = document.getElementById("toggleButton");
const expandButton = document.getElementById("expandButton");

toggleButton.addEventListener("click", () => {
    sidebar.classList.toggle("hidden");
    toggleExpandButtonVisibility(sidebar.classList.contains("hidden"));
});

expandButton.addEventListener("click", () => {
    sidebar.classList.remove("hidden");
    toggleExpandButtonVisibility(false);
});

const toggleExpandButtonVisibility = (isSidebarMinimized) => {
    expandButton.classList.toggle("hidden", !isSidebarMinimized);
};