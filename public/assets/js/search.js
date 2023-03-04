$(document).ready(() => {
  $('#cari').keyup(() => {
      let cari = $('#cari').val();
      let place = $('#place');

      let searchMin = $('#searchMin');
      if (cari.length < 2) {
          searchMin.show();
          place.hide();
      } else {
          searchMin.hide();
          place.show();
          $.ajax({
              type: "post",
              url: "/ajax/cari/" + cari,
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: {
                  cari: cari
              },
              success: function(data) {
                  if (data.status == true) {
                      $('#place').html(data.html);
                  } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          html: data.message
                      });
                  }
              },
          });
      }
  });
});