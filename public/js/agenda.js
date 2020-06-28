document.addEventListener('DOMContentLoaded', function (){
    
    var data = new Date();
    var mes = data.getMonth()+1;
    var dia = data.getDate();
    
    var data_atual = data.getFullYear()+'-0'+mes+'-'+dia;

    var calendarEl = document.getElementById('calendario');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt-br',
        plugins: ['interaction', 'dayGrid'],        
        editable: true,
        eventLimit: true,
        events: '/admin/listar_agenda',
        extraParams: function () {
            return {
                cachebuster: new Date().valueOf()
            };
        },
        selectable: true,
        selectConstraint: 
        {
            start: data_atual,
            end: ''
        },
        select: function(info){        
            $('#cadastrar #start').val(info.start.toLocaleString());
            $('#cadastrar #end').val(info.end.toLocaleString());
            $('#cadastrar').modal('show');
        },
        eventClick: function (info){
            info.jsEvent.preventDefault(); // don't let the browser navigate
            
            $.ajax({
                method: 'get',
                url: '/admin/mostar_agenda/'+info.event.id,
                data: '',
                success: function(resp)
                {
                    let obj = jQuery.parseJSON(resp);
                    
                    let cliente = obj.cliente;
                    let agenda = obj.agenda;
                    
                    let option = '';
                    
                    for(let i in cliente)
                    {
                        if(agenda[0].id_cliente == cliente[i].id)
                        {
                            option+= '<option value="'+cliente[i].id+'" selected>'+cliente[i].nome+'</option>';
                        }
                        else
                        {
                            option+= '<option value="'+cliente[i].id+'">'+cliente[i].nome+'</option>';
                        }
                    }
                    
                    $('#cliente').append(option);
                    
                    $('#visualizar #id_agenda').val(agenda[0].id);
                    $('#visualizar #title').val(agenda[0].title);
                    $('#visualizar #start').val(agenda[0].start);
                    $('#visualizar #end').val(agenda[0].end);
                    
                    $('#visualizar').modal('show');                    
                }
            });
        }
    });

    calendar.render();        
});

$('#editAgenda').click(function(){
    
    $.ajax({
        method: 'post',
        url: '/admin/agenda/id',
        data: '_token='+$("input[name*='_token']").val()+'&id='+$('#visualizar #id_agenda').val()+
              '&cliente='+$('#cliente').val()+'&titulo='+$('#visualizar #title').val()+
              '&inicio='+$('#visualizar #start').val()+'&fim='+$('#visualizar #end').val(),
        success: function(resp)
        {
            location.href = '/admin/agenda/'+resp;
        }
    });
});

$('#delAgenda').click(function(){
    
    $.ajax({
        method: 'post',
        url: '/admin/agenda/del/'+$('#visualizar #id_agenda').val(),
        data: '_token='+$("input[name*='_token']").val(),              
        success: function(resp)
        {
           /*if(resp == 1)
           {
               location.href = '/admin/agenda/3';
           }*/
            
             location.href = '/admin/agenda/'+resp;
        }
    });
});


//Mascara para o campo data e hora
function DataHora(evento, objeto) 
{
    var keypress = (window.event) ? event.keyCode : evento.which;
    campo = eval(objeto);
    
    if (campo.value == '00/00/0000 00:00:00') 
    {
        campo.value = "";
    }

    caracteres = '0123456789';
    separacao1 = '/';
    separacao2 = ' ';
    separacao3 = ':';
    conjunto1 = 2;
    conjunto2 = 5;
    conjunto3 = 10;
    conjunto4 = 13;
    conjunto5 = 16;
    
    if ((caracteres.search(String.fromCharCode(keypress)) != -1) && campo.value.length < (19)) 
    {
        if (campo.value.length == conjunto1)
            campo.value = campo.value + separacao1;
        else if (campo.value.length == conjunto2)
            campo.value = campo.value + separacao1;
        else if (campo.value.length == conjunto3)
            campo.value = campo.value + separacao2;
        else if (campo.value.length == conjunto4)
            campo.value = campo.value + separacao3;
        else if (campo.value.length == conjunto5)
            campo.value = campo.value + separacao3;
    } 
    else 
    {
        event.returnValue = false;
    }
}

