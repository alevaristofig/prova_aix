$(document).ready(function(){
            
    $('#cep').mask('99.999-999');
    
    $('#aluno_lista').DataTable({
        language: 
            {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
            },     
            processing: true,
            serverSide: true,
            ajax: 
            {
                url: "/aluno/listar" ,                
            },
            columns: [
                {
                    data: 'id',
                    name: 'id' 
                },
                {
                    data: 'nome',
                    name: 'nome' 
                },
                { 
                    data: 'situacao',
                    name: 'situacao' 
                },                   
                { 
                    data: 'acoes',
                    name: 'acoes',
                    orderable: false
                }
            ]                 
    });
     
    $('#curso_lista').DataTable({
            language: 
                {
                    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
                },               
                serverSide: true,
                ajax: 
                {
                    url: "/curso/listar" 
                },
                columns: [                    
                    {
                        data: 'codigo',
                        name: 'codigo' 
                    },
                    {
                        data: 'nome',
                        name: 'nome' 
                    },                                       
                    { 
                        data: 'acoes',
                        name: 'acoes',
                        orderable: false
                    }
                ]
     });
     
    $('#cep').keyup(function(){
        if($(this).val().length == 10)
        {
            let cep = $(this).val().replace('.','');
            cep = cep.replace('-','');
            
            $.getJSON("http://serviceweb.aix.com.br/aixapi/api/cep/"+cep, function(dados) {
              
                $('#logradouro').val(dados.logradouro);
                $('#bairro').val(dados.bairro);
                $('#cidade').val(dados.cidade);
                $('#estado').val(dados.estado);                                       
            });    
        }
    })
        
});

function codigo()
{
    //const valores = Array(10, 11, 16, 20, 54, 22, 8, 2);
    const valores = Array(11, 54, 16, 10, 20, 22, 8, 2);//organizei o array
    let total = 0;
    // tslint:disable-next-line:prefer-for-of
   
    for (let index = 0; index < valores.length; index++) 
    {
        const element = valores[index];
        
        if (index % 2 === 0) //pega o resta da divisão por dois
        {
            console.log(element+'<br>');
            total+= element;
        }
    }
    console.log("Total: " + total);

}


