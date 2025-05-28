/**
 * Scripts para cliente
 */
$(document).ready(function () {
    fetch('/api/v1/plans', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
        credentials: 'include'
    })
        .then(response => response.json())
        .then(json => {
            
        })
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
});

// function buildPlansCards(data) {
//     $('<div>',{class: 'col-12 col-lg-6 col-xl-4'}).append(
//         $('<div>',{class: 'card mb-4 mb-xl-0'}).append(
//             $('<div>',{class: 'card-header border-gray-100 py-5 px-4'}).append(
//                 $('<div>',{class: 'd-flex mb-3'}).append(
//                     $('<span>',{class: 'h5 mb-0'}).text('A partir de R$'),
//                     $('<span>',{class: 'price display-2 mb-0'}).text(data.price),
//                     $('<span>',{class: 'h6 fw-normal align-self-end'}).text('/mês')
//                 ),
//                 $('<h4>',{class: 'mb-3 text-black'}).text(data.nome),
//             ),            
//             $('<div>',{class: 'card-body py-5 px-4'}).append(
//                 ((data.ser)=>{

//                 })()
//                 $('<div>',{class: 'd-flex justify-content-between align-items-center mt-4'}).append(
//                     $('<a>',{class: 'btn btn-primary', href: '/plans/' + data.id}).text('Assinar')
//                 )
//     )
// }