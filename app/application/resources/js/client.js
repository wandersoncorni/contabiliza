/**
 * Scripts para cliente
 */
$(document).ready(function () {
    $('#sidebarMenu ul li a').on('click', function (e) {
        if($(this).attr('href') === '/agents'){
            e.preventDefault();
            if($.fn.dataTable.isDataTable('#tb-agents')) $('#tb-agents').DataTable().destroy();
            const tb = loadUsersTable('#tb-agents','/api/v1/agents');
        }
        else if($(this).attr('href') === '/companies'){
            e.preventDefault();
            const tb = new DataTable('#tb-companies','/api/v1/companies');
        }
        else if($(this).attr('href') === '/partners'){
            e.preventDefault();
            const tb = new DataTable('#tb-partners','/api/v1/partners');
        }
    });
    // const db = new DataTable('#tb-agents', {
    //     ajax: (data, callback) => fetch('/api/v1/agents',{
    //         method: 'GET',
    //         credentials: 'include'
    //     }).then(response => response.json())
    //     .then(data => {
    //         return data;
    //     })
    // })
});