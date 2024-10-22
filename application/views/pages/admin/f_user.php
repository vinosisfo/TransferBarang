<div class="content-wrapper"> 
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab"><span class="badge bg-blue">List Data user</span></a></li>
            <?php if($this->session->userdata("level")==="ADMIN PPIC") { ?>
            <li><a href="#" data-toggle="modal" data-target="#modal-default"><span class="badge bg-red">Input Data User</span></a></li>
            <?php } ?>
          </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="fa-icons">
              <div class="box">
                <div class="panel-body">
                     <form id="form-filter" method='post' class="form-horizontal" action="<?php echo base_url('data_shading/export_list') ?>">
                      <table class="table table-striped table-responsive" style="width: 100%; table-layout: auto; padding-bottom: 0px;">
                        <tr>
                          <td style="width: 10%;">Level</td>
                          <td style="width: 20%;">
                             <select name="level_src" id="level_src" class="form-control" style="width: 100%;">
                              <option value="">--PILIH--</option>
                              <option value="ADMIN PPIC">ADMIN PPIC</option>
                              <option value="PIMPINAN">PIMPINAN</option>
                              <option value="GUDANG">GUDANG</option>
                            </select>
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
                    <table id="data_user" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Kode user</th>
                          <th>username</th>
                          <th>password</th>
                          <th>level</th>            
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
        <h4 class="modal-title">Input Data User</h4>
        <br>
        <span id="pesan_d"></span>
      </div>

      <form id="form_input">
      <div class="modal-body">
        <div class="form-group">
          <label>Username</label>
          <input type="text" name="username" id="username" class="form-control" style="width: 50%;" autocomplete="off" required maxlength="50">
        </div>
        <div class="form-group">
          <label>password</label>
          <input type="password" name="password" id="password" class="form-control" style="width: 50%;" required maxlength="15">
        </div>
        <div class="form-group">
          <label>Level</label>
          <select name="level" id="level" class="form-control" style="width: 50%;" required>
            <option value="">--PILIH--</option>
            <option value="ADMIN PPIC">ADMIN PPIC</option>
            <option value="PIMPINAN">PIMPINAN</option>
            <option value="GUDANG">GUDANG</option>
          </select>
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
        <h4 class="modal-title">Edit Data User</h4>
      </div>

      <form id="form_edit">
      <div class="modal-body">
        <div class="form-group">
          <label>Username</label>
          <input type="hidden" name="e_kd_user" id="e_kd_user">
          <input type="text" name="e_username" id="e_username" class="form-control" style="width: 50%;" autocomplete="off" required maxlength="50">
        </div>
        <div class="form-group">
          <label>password</label>
          <input type="password" name="e_password" id="e_password" class="form-control" style="width: 50%;" required maxlength="15">
        </div>
        <div class="form-group">
          <label>Level</label>
          <select name="e_level" id="e_level" class="form-control" style="width: 50%;" required>
           
          </select>
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
  table = $('#data_user').DataTable({ 
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "info"      : true,
    "lengthChange": false,
    "ordering": false,
    "order": [], //Initial no order.

    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('c_user/list_data_user')?>",
      "type": "POST",
      "data": function (data) 
      {
        data.level_src = $('#level_src').val();
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
  $("#data_user_filter").css("display","none");


  $("#form_input").validate({
    rules: {
      username  : "required",
      password  : "required",
      level     : "required",
    },
    messages: {
      username  : "<font color='red'>Username Harus Diisi</font>",
      password  : "<font color='red'>password Harus Diisi</font>",
      level     : "<font color='red'>Level Harus Diisi</font>",
    }
  })

  $('#btn_input').click(function() {
    $("#form_input").valid();
  });


   $("#form_edit").validate({
    rules: {
      e_username  : "required",
      e_password  : "required",
      e_level     : "required",
    },
    messages: {
      e_username  : "<font color='red'>Username Harus Diisi</font>",
      e_password  : "<font color='red'>password Harus Diisi</font>",
      e_level     : "<font color='red'>Level Harus Diisi</font>",
    }
  })

  $('#btn_edit').click(function() {
    $("#form_edit").valid();
  });

  function simpan_data()
  {
    let username  = $("#username").val();
    let password  = $("#password").val();
    let level     = $("#level").val();
    $.ajax({
      url   : "<?php echo base_url('c_user/simpan_data')?>",
      type  : "POST",
      data  : {
        username  : username,
        password  : password,
        level     : level,
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
      url   : "<?php echo base_url('c_user/hapus_data/')?>"+kode,
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
    url   : "<?php echo base_url('c_user/edit_data/')?>"+kode,
    success : function(data)
    {
       let json  = data,
          obj       = JSON.parse(json);
          $("#e_kd_user").val(obj.kode_user);
          $("#e_username").val(obj.username);
          $("#e_level").html(obj.level);
          $("#modal-edit").modal('show');
    }
    })
  }
  <?php } ?>
  function udpate_data()
  {
    let kode_user = $("#e_kd_user").val();
    let username  = $("#e_username").val();
    let password  = $("#e_password").val();
    let level     = $("#e_level").val();
    $.ajax({
      url   : "<?php echo base_url('c_user/update_data')?>",
      type  : "POST",
      data  : {
        e_kd_user   : kode_user,
        e_username  : username,
        e_password  : password,
        e_level     : level,
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