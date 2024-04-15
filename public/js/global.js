$wire.on('fnExecListener', (e) => {    
   
    let fnExec  = e.function;
    let evExec  = JSON.stringify(e);

    setTimeout(() => {
        
        eval(`${ fnExec }(${ evExec })`);
    
    }, 12);

});

const initClockpicker = () => {
        
    $('.clockpicker').clockpicker();

}

const initSelectpicker = () => {

    $('.selectpicker').selectpicker();

}

const showModal = (e) => {

    $('#' + e.target).modal('show');

}

const hideModal = (e) => {

    $('#' + e.target).modal('hide');

}

const toastMessage = (e) => {
    
    let msg = e.content;
    
    Swal.fire({
        type                : msg.type,
        title               : msg.title,
        html                : `<b>${msg.text}</b>`,
        showConfirmButton   : false,
        timer               : 3000,
        toast               : true,
        position            : 'top-right',
    });

}

const alertDeleteItem = (e) => {

    let item    = e.content;

    Swal.fire({
        title               :`Estás apunto de eliminar ${ item.inModule }: ${ item.name }.`,
        text                :'¿Deseas continuar?',
        type                :'info',
        buttonsStyling      : false,
        reverseButtons      : true,
        showCancelButton    : true,
        showConfirmButton   : true,
        customClass         : {
            confirmButton   : 'btn btn-dark waves-effect waves-light float-right',
            cancelButton    : 'btn btn-danger waves-effect waves-light float-right mr-3'
        },
        confirmButtonText   : '<i class="fe-check mr-1"></i> Si',
        cancelButtonText    : '<i class="fe-x mr-1"></i> No',
    }).then(function(t){
            
        if (t.value) {
            
            $wire.dispatch(e.target, {id: item.id});

        }

    });

}

const selectRefresh = (select) => {
    
    select.selectpicker('refresh');

}

const selectSelected = (e) => {

    let selectTarget    = $('#' + e.target);
    let optionsSelected = e.content;
    
    if (optionsSelected) {

        optionsSelected.forEach( val => {
            
            selectTarget.find(`option[value="${ val }"]`).prop('selected', true);
    
        });
        

    } else {

        selectTarget.val('');

    }
    
    selectRefresh(selectTarget);

}

const selectOptions = (e) => {

    let selectTarget    = $('#' + e.target);
    let listItems       = e.content;
    let options         = ``;
    
    listItems.forEach( item => {
        
        options += `<option value="${ item.id }">${ item.name }</option>`;

    });

    selectTarget.html(options);

    selectRefresh(selectTarget);

}

// $wire.on('modalMessage', (e) => {
                
//     Swal.fire({
//         type             : e.type,
//         title            : e.title,
//         html             : `<b>${e.text}</b>`,
//         buttonsStyling   : false,
//         showCancelButton : false,
//         showConfirmButton: true,
//         customClass      : {
//             confirmButton : 'btn btn-dark waves-effect waves-light float-right',
//         },
//         confirmButtonText: '<i class="fe-check-circle mr-1"></i> Aceptar',
//     });
    
// });
