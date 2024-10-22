<div class="content-wrapper"> 
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab"><span class="badge bg-blue">List Data Supplier</span></a></li>
            <li><a href="#" data-toggle="modal" data-target="#modal-default"><span class="badge bg-red">Input Data Supplier</span></a></li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="fa-icons">
              <div class="box">
                <div class="panel-body">
                     <form id="form-filter" method='post' class="form-horizontal">
                      <table class="table table-striped table-responsive" style="width: 100%; table-layout: auto; padding-bottom: 0px;">
                        <tr>
                          <td style="width: 10%;">Nama Supplier</td>
                          <td style="width: 20%;">
                             <input type="text" name="nama_sp_src" id="nama_sp_src" style="width: 100%;">
                          </td>
                          <td style="width: 70%; text-align: left;">
                            <button type="button" id="btn-filter" class="btn btn-primary">Cari&nbsp;</button>
                            <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                          </td>
                        </tr>
                      </table>
                    </form>
                  </div>
                <div class="box-body scrolltable">
                  <div class="table-responsive">
                    <h5 class="text-success">
                      <span id="pesan_v"></span>
                      <span id="pesan_s"></span>
                      <span id="pesan_g"></span>
                    </h5>
                    <table id="data_supplier" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Kode supplier</th>
                          <th>Nama Supplier</th>
                          <th>No Telepon</th>
                          <th>Email</th>            
                          <th>Alamat</th>
                          <th>Keterangan</th>
                          <th>Edit</th>
                          <th>Hapus</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>

                        </tr>
                      </tbody>
                    </table>
                     <!-- <td><button type="button" onclick="hapus_data('hapus')">hapus</button></td> -->
                  </div>
                </div>
              </div> 
            </div>
          </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div>
  </section><!-- /.content -->
</div>

<!-- modal -->
<div class="modal fade" id="modal-default"> 
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Input Data Supplier</h4>
        <br>
        <span id="pesan_d"></span>
      </div>

      <form id="form_input">
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Supplier</label>
          <input type="text" name="nama_sp" id="nama_sp" class="form-control" style="width: 50%;" autocomplete="off" required maxlength="100" placeholder="Nama Supplier">
        </div>
        <div class="form-group">
          <label>No Telepon</label>
          <input type="text" name="no_tlp_sp" id="no_tlp_sp" class="form-control" style="width: 50%;" required maxlength="13" onkeypress="return hanyaAngka(event)" autocomplete="off" placeholder="No tlp">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email_sp" id="email_sp" class="form-control" style="width: 50%;" required maxlength="50"
          autocomplete="off" placeholder="Email">
        </div>
        <div class="form-group">
          <label>Alamat</label>
          <textarea name="alamat_sp" id="alamat_sp" class="form-control" style="width: 50%;" placeholder="ALAMAT" required></textarea>
        </div>
        <div class="form-group">
          <label>Keterangan</label>
          <textarea name="keterangan_sp" id="keterangan_sp" class="form-control" style="width: 50%;" placeholder="Keterangan"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <div class="form-group" style="text-align: left;">
        <button type="button" class="btn btn-primary btn-sm" id="btn_input" onclick="simpan_data(this);" style="width: 150px;">Save</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- edit -->
<!-- modal -->
<div class="modal fade" id="modal-edit"> 
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Data Supplier</h4>
        <br>
        <span id="pesan_d"></span>
      </div>

      <form id="form_edit">
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Supplier</label>
          <input type="hidden" name="e_kode_sp" id="e_kode_sp">
          <input type="text" name="e_nama_sp" id="e_nama_sp" class="form-control" style="width: 50%;" autocomplete="off" required maxlength="100" placeholder="Nama Supplier">
        </div>
        <div class="form-group">
          <label>No Telepon</label>
          <input type="text" name="e_no_tlp_sp" id="e_no_tlp_sp" class="form-control" style="width: 50%;" required maxlength="13" onkeypress="return hanyaAngka(event)" autocomplete="off" placeholder="No tlp">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="e_email_sp" id="e_email_sp" class="form-control" style="width: 50%;" required maxlength="50"
          autocomplete="off" placeholder="Email">
        </div>
        <div class="form-group">
          <label>Alamat</label>
          <textarea name="e_alamat_sp" id="e_alamat_sp" class="form-control" style="width: 50%;" placeholder="ALAMAT" required></textarea>
        </div>
        <div class="form-group">
          <label>Keterangan</label>
          <textarea name="e_keterangan_sp" id="e_keterangan_sp" class="form-control" style="width: 50%;" placeholder="Keterangan"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <div class="form-group" style="text-align: left;">
        <button type="button" class="btn btn-primary btn-sm" id="btn_edit" onclick="update_data(this);" style="width: 150px;">Upadate</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
var table;
  table = $('#data_supplier').DataTable({ 
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "info"      : true,
    "lengthChange": false,
    "ordering": false,
    "order": [], //Initial no order.

    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('c_supplier/list_data_supplier')?>",
      "type": "POST",
      "data": function (data) 
      {
        data.nama_sp_src = $('#nama_sp_src').val();
      }
    },
    "columnDefs": [
      { 
        "targets": [ 0 ], //first column / numbering column
        "orderable": false, //set not orderable
      },
    ]

  });

  $('#btn-filter').click(function(){ //button filter event click
    table.ajax.reload();  //just reload table
  });

  $('#btn-reset').click(function(){ //button reset event click

  $('#form-filter')[0].reset();
    table.ajax.reload();  //just reload table
  });
  $("#data_supplier_filter").css("display","none");


  $("#form_input").validate({
    rules: {
      nama_sp    : "required",
      no_tlp_sp  : "required",
      email_sp   : "required",
      alamat_sp  : "required",
    },
    messages: {
      nama_sp   : "<font color='red'>Nama Harus Diisi</font>",
      no_tlp_sp : "<font color='red'>No Tlp Harus Diisi</font>",
      email_sp  : "<font color='red'>Email Harus Diisi</font>",
      alamat_sp : "<font color='red'>Alamat Harus Diisi</font>",
    }
  })

  $('#btn_input').click(function() {
    $("#form_input").valid();
  });


   $("#form_edit").validate({
    rules: {
      e_nama_sp    : "required",
      e_no_tlp_sp  : "required",
      e_email_sp   : "required",
      e_alamat_sp  : "required",
    },
    messages: {
      e_nama_sp   : "<font color='red'>Nama Harus Diisi</font>",
      e_no_tlp_sp : "<font color='red'>No Tlp Harus Diisi</font>",
      e_email_sp  : "<font color='red'>Email Harus Diisi</font>",
      e_alamat_sp : "<font color='red'>Alamat Harus Diisi</font>",
    }
  })

  $('#btn_edit').click(function() {
    $("#form_edit").valid();
  });

  function simpan_data()
  {
    let nama_sp         = $("#nama_sp").val();
    let no_tlp_sp       = $("#no_tlp_sp").val();
    let email_sp        = $("#email_sp").val();
    let alamat_sp       = $("#alamat_sp").val();
    let keterangan_sp   = $("#keterangan_sp").val();
    $.ajax({
      url   : "<?php echo base_url('c_supplier/simpan_data')?>",
      type  : "POST",
      data  : {
        nama_sp     : nama_sp,
        no_tlp_sp   : no_tlp_sp,
        email_sp    : email_sp,
        alamat_sp   : alamat_sp,
        keterangan_sp : keterangan_sp,
      },
      success : function(data)
      {
        let json  = data,
        obj       = JSON.parse(json);
        $("#pesan_v").html(obj.pesan_valid);
        $("#pesan_d").html(obj.pesan_valid);
        $("#pesan_s").html(obj.pesan_simpan);
        $("#pesan_g").html(obj.pesan_gagal);
        if(obj.pesan_simpan.trim()!=''){
          $('#form_input')[0].reset();
          $("#modal-default").modal('hide');
        }
        table.ajax.reload();
        setTimeout(function()
        {
          $("#pesan_v").remove();
          $("#pesan_s").remove();
          $("#pesan_g").remove();
          $("#pesan_d").remove();
        }, 5000)
      }
    })
  }

  <?php for ($i=1; $i <=20 ; $i++) { ?>
  function hapus_data_<?php echo $i ?>()
  {
    let kode = $("#hapus_id_<?php echo $i ?>").val();
    $.ajax({
      url   : "<?php echo base_url('c_supplier/hapus_data/')?>"+kode,
      // type  : "POST",
      success : function(data)
      {
        let json  = data,
        obj       = JSON.parse(json);
        $("#pesan_v").html(obj.pesan_valid);
        table.ajax.reload();
        setTimeout(function()
        {
          $("#pesan_v").remove();
        }, 5000)
      }
    })
  }

  function edit_data_<?php echo $i ?>()
  {
    let kode = $("#edit_id_<?php echo $i ?>").val();
    $.ajax({
    url   : "<?php echo base_url('c_supplier/edit_data/')?>"+kode,
    success : function(data)
    {
       let json  = data,
          obj       = JSON.parse(json);
          $("#e_kode_sp").val(obj.kode_sp);
          $("#e_nama_sp").val(obj.nama_sp);
          $("#e_no_tlp_sp").val(obj.no_tlp_sp);
          $("#e_email_sp").val(obj.email_sp);
          $("#e_alamat_sp").val(obj.alamat_sp);
          $("#e_keterangan_sp").val(obj.keterangan_sp);


          $("#modal-edit").modal('show');
    }
    })
  }
  <?php } ?>
  function update_data()
  {
    let e_kode_sp         = $("#e_kode_sp").val();
    let e_nama_sp         = $("#e_nama_sp").val();
    let e_no_tlp_sp       = $("#e_no_tlp_sp").val();
    let e_email_sp        = $("#e_email_sp").val();
    let e_alamat_sp       = $("#e_alamat_sp").val();
    let e_keterangan_sp   = $("#e_keterangan_sp").val();
    $.ajax({
      url   : "<?php echo base_url('c_supplier/update_data')?>",
      type  : "POST",
      data  : {
        e_kode_sp   : e_kode_sp,
        e_nama_sp     : e_nama_sp,
        e_no_tlp_sp   : e_no_tlp_sp,
        e_email_sp    : e_email_sp,
        e_alamat_sp   : e_alamat_sp,
        e_keterangan_sp : e_keterangan_sp,
      },
      success : function(data)
      {
        let json  = data,
        obj       = JSON.parse(json);
        $("#pesan_v").html(obj.pesan_valid);
        $("#pesan_d").html(obj.pesan_valid);
        $("#pesan_s").html(obj.pesan_simpan);
        $("#pesan_g").html(obj.pesan_gagal);
        $("#modal-edit").modal('hide');
        if(obj.pesan_simpan.trim()!=''){
          $('#form_edit')[0].reset();
          $("#modal-edit").modal('hide');
        }
        table.ajax.reload();
        setTimeout(function()
        {
          $("#pesan_v").remove();
          $("#pesan_s").remove();
          $("#pesan_g").remove();
          $("#pesan_d").remove();
        }, 5000)
      }
    })
  }

</script>