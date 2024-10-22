<div class="content-wrapper"> 
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab"><span class="badge bg-blue">List Data Barang</span></a></li>
            <li><a href="#" data-toggle="modal" data-target="#modal-default"><span class="badge bg-red">Input Data Barang</span></a></li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="fa-icons">
              <div class="box">
                <div class="panel-body">
                     <form id="form-filter" method='post' class="form-horizontal">
                      <table class="table table-striped table-responsive" style="width: 100%; table-layout: auto; padding-bottom: 0px;">
                        <tr>
                          <td style="width: 10%;">Nama Barang</td>
                          <td style="width: 20%;">
                            <input type="text" name="barang" id="barang" class="form-control">
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
                    <span class="pesan_validasi"></span>
                    <span class="pesan_gagal"></span>
                    <span class="pesan_sukses"></span>
                    <span id="pesan_hapus"></span>
                    <table id="data_barang" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Jenis Barang</th>
                          <th>Kategori Barang</th>   
                          <th>Stok Barang</th>         
                          <th>Edit</th>
                          <th>Hapus</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>

                        </tr>
                      </tbody>
                    </table>
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
        <h4 class="modal-title">Input Data Barang</h4>
        <span class="pesan_validasi"></span>
        <span class="pesan_gagal"></span>
        <span class="pesan_sukses"></span>
      </div>

      <form id="form_input">
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Barang</label>
          <input type="text" name="barang_add" id="barang_add" class="form-control" style="width: 50%;" autocomplete="off" required maxlength="50">
        </div>
        <div class="form-group">
          <label>Jenis Barang</label>
          <input type="text" name="jenis_add" id="jenis_add" class="form-control" style="width: 50%;" required maxlength="50">
        </div>
        <div class="form-group">
          <label>Kategori Barang</label>
          <input type="text" name="kategori_add" class="form-control" id="kategori_add" style="width: 50%;" required maxlength="50">
        </div>
        <!-- <div class="form-group">
          <label>Stok</label>
          <input type="text" name="stok_add" id="stok_add" style="width: 50%;" required maxlength="4" onkeypress="return hanyaAngka(event)">
        </div> -->
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
        <h4 class="modal-title">Edit Data Barang</h4>
        <span class="pesan_validasi"></span>
        <span class="pesan_gagal"></span>
        <span class="pesan_sukses"></span>
      </div>

      <form id="form_edit">
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Barang</label>
          <input type="hidden" name="kode_barang" id="kode_barang">
          <input type="text" name="barang_edit" id="barang_edit" class="form-control" style="width: 50%;" autocomplete="off" required maxlength="50">
        </div>
        <div class="form-group">
          <label>Jenis Barang</label>
          <input type="text" name="jenis_edit" id="jenis_edit" class="form-control" style="width: 50%;" required maxlength="50">
        </div>
        <div class="form-group">
          <label>Kategori Barang</label>
          <input type="text" name="kategori_edit" class="form-control" id="kategori_edit" style="width: 50%;" required maxlength="50">
        </div>
        <!-- <div class="form-group">
          <label>Stok</label>
          <input type="text" name="stok_add" id="stok_add" style="width: 50%;" required maxlength="4" onkeypress="return hanyaAngka(event)">
        </div> -->
      </div>
      <div class="modal-footer">
        <div class="form-group" style="text-align: left;">
        <button type="button" class="btn btn-primary btn-sm" id="btn_edit" onclick="udpate_data(this);" style="width: 150px;">Update</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
var table;
  table = $('#data_barang').DataTable({ 
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "info"      : true,
    "lengthChange": false,
    "ordering": false,
    "order": [], //Initial no order.

    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('c_barang/list_data_barang')?>",
      "type": "POST",
      "data": function (data) 
      {
        data.barang = $('#barang').val();
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
  $("#data_barang_filter").css("display","none");


  $("#form_input").validate({
    rules: {
      barang_add    : "required",
      jenis_add     : "required",
      kategori_add  : "required",
    },
    messages: {
      barang_add    : "<font color='red'>Nama Barang Harus Diisi</font>",
      jenis_add     : "<font color='red'>Jenis Barang Harus Diisi</font>",
      kategori_add  : "<font color='red'>Kategori Barang Harus Diisi</font>",
    }
  })

  $('#btn_input').click(function() {
    $("#form_input").valid();
  });


   $("#form_edit").validate({
    rules: {
      barang_edit    : "required",
      jenis_edit     : "required",
      kategori_edit  : "required",
    },
    messages: {
      barang_edit    : "<font color='red'>Nama Barang Harus Diisi</font>",
      jenis_edit     : "<font color='red'>Jenis Barang Harus Diisi</font>",
      kategori_edit  : "<font color='red'>Kategori Barang Harus Diisi</font>",
    }
  })

  $('#btn_edit').click(function() {
    $("#form_edit").valid();
  });

  function simpan_data()
  {
    $.ajax({
      url   : "<?php echo base_url('c_barang/simpan_data')?>",
      type  : "POST",
      data  : $("#form_input").serialize(),
      success : function(data)
      {
        let json  = data,
        obj       = JSON.parse(json);
        $(".pesan_validasi").html(obj.pesan_validasi);
        $(".pesan_gagal").html(obj.pesan_gagal);
        $(".pesan_sukses").html(obj.pesan_sukses);
        if(obj.pesan_sukses.trim()!=''){
          $('#form_input')[0].reset();
          $("#modal-default").modal('hide');
        }
        table.ajax.reload();
        setTimeout(function()
        {
          $(".pesan_validasi").remove();
          $(".pesan_gagal").remove();
          $(".pesan_sukses").remove();
        }, 5000)
      }
    })
  }

  <?php for ($i=1; $i <=20 ; $i++) { ?>
  function hapus_data_<?php echo $i ?>()
  {
    let kode = $("#hapus_id_<?php echo $i ?>").val();
    $.ajax({
      url   : "<?php echo base_url('c_barang/hapus_data/')?>"+kode,
      // type  : "POST",
      success : function(data)
      {
        let json  = data,
        obj       = JSON.parse(json);
        $("#pesan_hapus").html(obj.pesan_hapus);
        table.ajax.reload();
        setTimeout(function()
        {
          $("#pesan_hapus").remove();
        }, 5000)
      }
    })
  }

  function edit_data_<?php echo $i ?>()
  {
    let kode = $("#edit_id_<?php echo $i ?>").val();
    $.ajax({
    url   : "<?php echo base_url('c_barang/edit_data/')?>"+kode,
    success : function(data)
    {
       let json  = data,
          obj       = JSON.parse(json);
          $("#kode_barang").val(obj.kode_barang);
          $("#barang_edit").val(obj.nama_barang);
          $("#jenis_edit").val(obj.jenis_barang);
          $("#kategori_edit").val(obj.kategori_barang);
          $("#modal-edit").modal('show');
    }
    })
  }
  <?php } ?>

  function udpate_data()
  {
   
    $.ajax({
      url   : "<?php echo base_url('c_barang/update_data')?>",
      type  : "POST",
      data  : $("#form_edit").serialize(),
      success : function(data)
      {
        let json  = data,
        obj       = JSON.parse(json);
        $(".pesan_validasi").html(obj.pesan_validasi);
        $(".pesan_gagal").html(obj.pesan_gagal);
        $(".pesan_sukses").html(obj.pesan_sukses);
        if(obj.pesan_sukses.trim()!=''){
          $('#form_edit')[0].reset();
          $("#modal-edit").modal('hide');
        }
        table.ajax.reload();
        setTimeout(function()
        {
          $(".pesan_validasi").remove();
          $(".pesan_gagal").remove();
          $(".pesan_sukses").remove();
        }, 5000)
      }
    })
  }

</script>