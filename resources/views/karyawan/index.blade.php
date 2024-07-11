@extends('layout.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <h2 class="page-title">
            Data Karyawan
          </h2>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @if (Session::get('success'))
                            <div class="alert alert-success">
                                {{Session::get('success')}}
                            </div>
                            @endif

                            @if (Session::get('warning'))
                            <div class="alert alert-warning">
                                {{Session::get('warning')}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="#" class="btn btn-primary" id="btnTambahkaryawan">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                Tambah Data
                            </a>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <form action="/karyawan" method="GET">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control" 
                                            placeholder="Nama Karyawan" value="{{ Request('nama_karyawan') }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <select name="kode_dept" id="kode_dept" class="form-select">
                                                <option value="">Departemen</option>
                                                @foreach ($departemen as $d)
                                                <option value="{{ Request('kode_dept')==$d->kode_dept ? 'selected' : '' }}" value=""{{ $d->kode_dept }}>{{ $d->nama_dept }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Jabatan</th>
                                        <th>No. HP</th>
                                        <th>Foto</th>
                                        <th>Departemen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($karyawan as $d)
                                    @php
                                      $path = Storage::url('upload/karyawan/'.$d->foto);
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration + $karyawan->firstItem() -1 }}</td>
                                        <td>{{ $d->nik }}</td>
                                        <td>{{ $d->nama_lengkap }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>{{ $d->jabatan }}</td>
                                        <td>{{ $d->no_hp }}</td>
                                        <td>                
                                            @if (empty($d->foto))
                                            <img src="{{ asset('assets/img/nofoto.png') }}" class="avatar" alt="">
                                            @else
                                            <img src="{{ url($path) }}" class="avatar" alt="">
                                            @endif
                                        </td>
                                        <td>{{ $d->nama_dept }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" class="edit btn btn-info btn-sm" nik="{{ $d->nik }}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a>
                                                <form action="/karyawan/{{ $d->nik }}/delete" method="POST" style="margin-left:5px">
                                                    @csrf
                                                    <a class="btn btn-danger btn-sm delete-confirm">
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                    </a>
                                                </form>
                                                </td>
                                            </div>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $karyawan->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="modal-inputkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Karyawan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/karyawan/store" method="POST" id="frmKaryawan" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-qrcode"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M7 17l0 .01" /><path d="M14 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M7 7l0 .01" /><path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M17 7l0 .01" /><path d="M14 14l3 0" /><path d="M20 14l0 .01" /><path d="M14 14l0 3" /><path d="M14 20l3 0" /><path d="M17 17l3 0" /><path d="M20 17l0 3" /></svg>
                        </span>
                        <input type="text" id="nik" value="" class="form-control" name="nik" placeholder="NIK">
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path></svg>
                        </span>
                        <input type="text" id="nama_lengkap" value="" class="form-control" name="nama_lengkap" placeholder="Nama Karyawan">
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-at"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28" /></svg>
                        </span>
                        <input type="text" id="email" value="" class="form-control" name="email" placeholder="Email">
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-tie"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 22l4 -4l-2.5 -11l.993 -2.649a1 1 0 0 0 -.936 -1.351h-3.114a1 1 0 0 0 -.936 1.351l.993 2.649l-2.5 11l4 4z" /><path d="M10.5 7h3l5 5.5" /></svg>
                        </span>
                        <input type="text" id="jabatan" value="" class="form-control" name="jabatan" placeholder="Jabatan">
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" /><path d="M11 4h2" /><path d="M12 17v.01" /></svg>
                        </span>
                        <input type="text" id="no_hp" value="" class="form-control" name="no_hp" placeholder="No. HP">
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <div class="form">Upload Pas Foto</div>
                        <input type="file" name="foto" class="form-control">
                      </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-12">
                        <select name="kode_dept" id="kode_dept" class="form-select">
                            <option value="">Departemen</option>
                            @foreach ($departemen as $d)
                            <option {{ Request('kode_dept')==$d->kode_dept ? 'selected' : '' }} value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary w-100"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                            Simpan</button>
                    </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- Modal Edit Karyawan --}}
  <div class="modal modal-blur fade" id="modal-editkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data Karyawan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadeditform">
         
        </div>
      </div>
    </div>
  </div>
@endsection
@push('myscript')
<script>
    $(function(){
        $("#btnTambahkaryawan").click(function(){
            $("#modal-inputkaryawan").modal("show");
        });

        $(".edit").click(function(){
            var nik = $(this).attr('nik');
            $.ajax({
                type:'POST',
                url:'/karyawan/edit',
                cache:'false',
                data:{
                    _token:"{{ csrf_token(); }}",
                    nik:nik,
                },
                success:function(respond){
                    $("#loadeditform").html(respond);
                }
            });
            $("#modal-editkaryawan").modal("show");
        });

        $(".delete-confirm").click(function(e){
            var form = $(this).closest('form');
            e.preventDefault();
            Swal.fire({
                title: "Apakah anda yakin menghapus data ini?",
                text: "Data Akan Terhapus Selamanya!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Batal",
                confirmButtonText: "Ya, Hapus saja!"
                }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire({
                    title: "Terhapus!",
                    text: "Data Berhasil Dihapus.",
                    icon: "success"
                    });
                }
                });
        });

        $("#frmKaryawan").submit(function(){
            var nik = $("#nik").val();
            var nama_lengkap = $("#nama_lengkap").val();
            var email = $("#email").val();
            var jabatan = $("#jabatan").val();
            var no_hp = $("#no_hp").val();
            var kode_dept = $("frmKaryawan").find("#kode_dept").val();
            if (nik == ""){
                Swal.fire("NIK Wajib Diisi!");
                $("#nik").focus();
                return false;
            } else if (nama_lengkap == ""){
                Swal.fire("namalengkap Wajib Diisi!");
                $("#nama_lengkap").focus();
                return false;
            } else if (email == ""){
                Swal.fire("Email Wajib Diisi!");
                $("#email").focus();
                return false;
            } else if (jabatan == ""){
                Swal.fire("Jabatan Wajib Diisi!");
                $("#jabatan").focus();
                return false;
            } else if (no_hp == ""){
                Swal.fire("No Hp Wajib Diisi!");
                $("#no_hp").focus();
                return false;
            } else if (kode_dept == ""){
                Swal.fire("kode departemen Wajib Diisi!");
                $("#kode_dept").focus();
                return false;
            }
        });
    });    
</script>   
@endpush