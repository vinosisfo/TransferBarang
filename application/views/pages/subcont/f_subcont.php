<div class="content-wrapper"> 
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab"><span class="badge bg-blue">List Data Subcont</span></a></li>
            <li><a href="#" data-toggle="modal" data-target="#modal-default"><span class="badge bg-red">Input Data Subcont</span></a></li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="fa-icons">
              <div class="box">
                <div class="panel-body">
                     <form id="form-filter" method='post' class="form-horizontal">
                      <table class="table table-striped table-responsive" style="width: 100%; table-layout: auto; padding-bottom: 0px;">
                        <tr>
                          <td style="width: 10%;">Subcont</td>
                          <td style="width: 20%;">
                            <input type="text" name="subcont" id="subcont" class="form-control">
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
                    <table id="data_subcont" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Kode Subcont</th>
                          <th>Nama Subcont</th>
                          <th>Alamat Subcont</th>
                          <th>No Telepon</th>   
                          <th>Email</th>         
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
        <h4 class="modal-title">Input Data Subcont</h4>
        <span class="pesan_validasi"></span>
        <span class="pesan_gagal"></span>
        <span class="pesan_sukses"></span>
      </div>

      <form id="form_input">
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Subcont</label>
          <input type="text" name="subcont_add" id="subcont_add" class="form-control" style="width: 50%;" autocomplete="off" required maxlength="50" placeholder="Nama">
        </div>
        <div class="form-group">
          <label>Alamat Barang</label>
          <textarea name="alamat_add" id="alamat_add" style="width: 50%;" class="form-control" maxlength="200" required placeholder="Almat"></textarea>
        </div>
        <div class="form-group">
          <label>No Telepon</label>
          <input type="text" name="tlp_add" class="form-control" id="tlp_add" style="width: 50%;" required maxlength="13" onkeypress="return hanyaAngka(event)">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="Email" name="email_add" id="email_add" style="width: 50%;" required maxlength="50" class="form-control">
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
        <h4 class="modal-title">Edit Data Subcont</h4>
        <span class="pesan_validasi"></span>
        <span class="pesan_gagal"></span>
        <span class="pesan_sukses"></span>
      </div>

      <form id="form_edit">
       <div class="modal-body">
        <div class="form-group">
          <label>Nama Subcont</label>
          <input type="text" name="kode_subcont" id="kode_subcont">
          <input type="text" name="subcont_edit" id="subcont_edit" class="form-control" style="width: 50%;" autocomplete="off" required maxlength="50" placeholder="Nama">
        </div>
        <div class="form-group">
          <label>Alamat Barang</label>
          <textarea name="alamat_edit" id="alamat_edit" style="width: 50%;" class="form-control" maxlength="200" required placeholder="Almat"></textarea>
        </div>
        <div class="form-group">
          <label>No Telepon</label>
          <input type="text" name="tlp_edit" class="form-control" id="tlp_edit" style="width: 50%;" required maxlength="13" onkeypress="return hanyaAngka(event)">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="Email" name="email_edit" id="email_edit" style="width: 50%;" required maxlength="50" class="form-control">
        </div>
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
  table = $('#data_subcont').DataTable({ 
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "info"      : true,
    "lengthChange": false,
    "ordering": false,
    "order": [], //Initial no order.

    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('c_subcont/list_data_subcont')?>",
      "type": "POST",
      "data": function (data) 
      {
        data.subcont = $('#subcont').val();
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
  $("#data_subcont_filter").css("display","none");


  $("#form_input").validate({
    rules: {
      subcont_add : "required",
      alamat_add  : "required",
      tlp_add     : "required",
      email_add   : "required",
    },
    messages: {
      subcont_add : "<font color='red'>Nama Subcont Barang Harus Diisi</font>",
      alamat_add  : "<font color='red'>Alamat Harus Diisi</font>",
      tlp_add     : "<font color='red'>Telepon Harus Diisi</font>",
      email_add   : "<font color='red'>Email Harus Diisi</font>",
    }
  })

  $('#btn_input').click(function() {
    $("#form_input").valid();
  });


   $("#form_edit").validate({
    rules: {
      subcont_edit : "required",
      alamat_edit  : "required",
      tlp_edit     : "required",
      email_edit   : "required",
    },
    messages: {
      subcont_edit : "<font color='red'>Nama Subcont Barang Harus Diisi</font>",
      alamat_edit  : "<font color='red'>Alamat Harus Diisi</font>",
      tlp_edit     : "<font color='red'>Telepon Harus Diisi</font>",
      email_edit   : "<font color='red'>Email Harus Diisi</font>",
    }
  })

  $('#btn_edit').click(function() {
    $("#form_edit").valid();
  });

  function simpan_data()
  {
    $.ajax({
      url   : "<?php echo base_url('c_subcont/simpan_data')?>",
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
      url   : "<?php echo base_url('c_subcont/hapus_data/')?>"+kode,
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
    url   : "<?php echo base_url('c_subcont/edit_data/')?>"+kode,
    success : function(data)
    {
       let json  = data,
          obj       = JSON.parse(json);
          $("#kode_subcont").val(obj.kode_subcont);
          $("#subcont_edit").val(obj.nama_subcont);
          $("#alamat_edit").val(obj.alamat_subcont);
          $("#tlp_edit").val(obj.no_tlp);
          $("#email_edit").val(obj.email);
          $("#modal-edit").modal('show');
    }
    })
  }
  <?php } ?>

  function udpate_data()
  {
   
    $.ajax({
      url   : "<?php echo base_url('c_subcont/update_data')?>",
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