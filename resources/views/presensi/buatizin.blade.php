@extends('layout.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal{
        max-height: 430px !important;
    }
    .datepicker-date-display{
        background-color: rgb(53, 53, 255) !important;
    }
</style>
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTittle">Form Izin/Sakit</div>
    <div class="right"></div>
</div>
@endsection
@section('content')
<div class="row" style="margin-top:70px">
    <div class="col">
        <form method="POST" action="/presensi/storeizin" id="frmIzin">
            @csrf
            <div class="form-group">
                <input type="text" name="tgl_izin" id="tgl_izin" class="form-control datepicker" placeholder="Tanggal">
            </div>
            <div class="form-group">
                <select name="status" id="status" class="form-control">
                    <option value="">Izin/Sakit</option>
                    <option value="i">Izin</option>
                    <option value="s">Sakit</option>
                </select>
            </div>
            <div class="form-group">
                <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control" placeholder="Keterangan"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary w-100">Kirim</button>
            </div>
        </form>
    </div>
</div>    
@endsection
@push('myscript')
<script>
  var currYear = (new Date()).getFullYear();

  $(document).ready(function() {
    $(".datepicker").datepicker({
      format: "yyyy-mm-dd"
    });

    $("#frmIzin").submit(function(){
      var tgl_izin = $("#tgl_izin").val();
      var status = $("#status").val();
      var keterangan = $("#keterangan").val();

      // Validasi tanggal
      if (tgl_izin == "") {
        Swal.fire({
          title: 'Opss!',
          text: 'Tanggal Izin Harus Diisi',
          icon: 'warning'
        });
        return false;
      }else if (status == "") {
        Swal.fire({
          title: 'Opss!',
          text: 'Status Izin Harus Diisi',
          icon: 'warning'
        });
        return false;
      }else if (keterangan == "") {
        Swal.fire({
          title: 'Opss!',
          text: 'Keterangan Izin Harus Diisi',
          icon: 'warning'
        });
        return false;
      }
    });

    $("#tgl_izin").change(function(e) {
  var tgl_izin = $(this).val();

  $.ajax({
    type: 'POST',
    url: '/presensi/cekpengajuanizin',
    data: {
      _token: "{{ csrf_token() }}",
      tgl_izin: tgl_izin
    },
    cache: false,
    success: function(respond) {
      if (respond == 1) {
        Swal.fire({
          title: 'Oops!',
          text: 'Anda Hanya Bisa Melakukan 1 Kali Izin ditanggal Yang sama!',
          icon: 'warning'
        }).then((result) => {
          $("#tgl_izin").val("");
        });
      }
    }
  });
});

  });
</script>
@endpush