// Funcion crear mostrar
$(document).on('click','.create-modal', function() {
    $('#create').modal('show');
    $('.form-horizontal').show();
    //Quitar errores
    $('.alert-danger').empty();
    $('.alert-danger').hide();
  });
  // Funcion crear
  $("#add").click(function() {
    $.ajax({
      type: 'post',
      url: 'plataforma/store',
      data: {
        '_token':$('input[name=_token]').val(),
        'nombre':$('input[name=nombre]').val()

      },
      success: function(data){
        if ((data.errors)) {
          $.each(data.errors,function(key,value){
            $('.alert-danger').empty();
            $('.alert-danger').hide();
          $('.alert-danger').show();
          $('.alert-danger').append('<p>'+value+'<p>');
        });

        }else{
          $('#table').append(
        "  <tr class='plataforma"+data.id+"'>"+
          "<td>"+data.nombre+"</td>"+
          "<td>"+data.created_at+"</td>"+
          "<td>"+
            "<a href='#' class='show-modal btn btn-info' data-id='"+data.id+"' data-nombre='"+data.nombre+"' >"+
            "<i class='far fa-eye'></i>"+
            "</a>"+
            "<a href='#' class='edit-modal btn btn-warning' data-id='"+data.id+"' data-nombre='"+data.nombre+"' >"+
            "<i class='far fa-edit'></i>"+
            "</a>"+

          "</td>"+
          "</tr>");

        }
      },
    });
    $('#nombre').val('');
  });

// Funcion editar Mostrar
$(document).on('click', '.edit-modal', function() {
$('.form-horizontal').show();
$('#fid').val($(this).data('id'));
$('#n').val($(this).data('nombre'));
$('#myModal').modal('show');
});
// Funcion editar
$('.modal-footer').on('click', '.edit', function() {
  $.ajax({
    type: 'post',
    url: 'plataforma/update/',
    data: {
      '_token':$('input[name=_token]').val(),
      'id':$('#fid').val(),
      'nombre':$('#n').val()

    },
success: function(data) {
  $('.plataforma'+data.id).replaceWith(
"<tr class='plataforma"+data.id+"'>"+
  "<td>"+data.nombre+"</td>"+
  "<td>"+data.created_at+"</td>"+
  "<td>"+
    "<a href='#' class='show-modal btn btn-info' data-id='"+data.id+"' data-nombre='"+data.nombre+"' >"+
    "<i class='far fa-eye'></i>"+
    "</a>"+
    "<a href='#' class='edit-modal btn btn-warning' data-id='"+data.id+"' data-nombre='"+data.nombre+"' >"+
    "<i class='far fa-edit'></i>"+
    "</a>"+

  "</td>"+
  "</tr>");
    }
  });
});

  // Funcion detalle
  $(document).on('click', '.show-modal', function() {
  $('#show').modal('show');
  $('#i').text($(this).data('id'));
  $('#nom').text($(this).data('nombre'));
  });
