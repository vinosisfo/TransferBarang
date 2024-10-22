<div class="content-wrapper"> 
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab"><span class="badge bg-blue">List Data Pengiriman</span></a></li>
            <li><a href="#" data-toggle="modal" data-target="#modal-default"><span class="badge bg-red">Input Data Pengiriman</span></a></li>
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
                            <input type="text" name="barang" id="barang" class="form-control">
                          </td>
                          <td style="width: 10%;">Tanggal</td>
                          <td style="width: 20%;"><input type="text" name="date1" id="date1" class="form-control datepicker"></td>
                          <td style="width: 20%;"><input type="text" name="date2" id="date2" class="form-control datepicker"></td>
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
                    <table id="data_pengiriman" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Kode pengiriman</th>
                          <th>Nama Subcont</th>
                          <th>Tanggal Kirim</th>
                          <th>Perkiraan Tiba</th>   
                          <th>Status Pengiriman</th>
                          <th>Detail</th>         
                          <!-- <th>Edit</th> -->
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
        <h4 class="modal-title">Input Data Pengiriman</h4>
        <span class="pesan_validasi"></span>
        <span class="pesan_gagal"></span>
        <span class="pesan_sukses"></span>
      </div>

      <form id="form_input">
      <div class="modal-body">
       <table class="table table-striped">
         <tr>
           <td>Subcont</td>
           <td>
             <select name="subcont_add" id="subcont_add" class="form-control select2" style="width: 100%;" required>
               <option value="">--PILIH--</option>
               <?php foreach ($subcont_data as $sbc) { ?>
                 <option value="<?php echo $sbc->kode_subcont ?>"><?php echo $sbc->nama_subcont ?></option>
               <?php } ?>
             </select>
           </td>
         </tr>
         <tr>
           <td>Tanggal</td>
           <td><input type="text" name="tanggal_kirim" id="tanggal_kirim" class="form-control datepicker" required></td>
         </tr>
         <tr>
           <td>Perkiraan Tiba</td>
           <td><input type="text" name="tanggal_tiba" id="tanggal_tiba" class="form-control datepicker" required></td>
         </tr>
       </table>
       <span><input type="button" name="add_btn" value="+add" id="add_btn" class="btn btn-xs btn-success"></span>
       <table class="table table-striped table-bordered" id="customFields">
         <tr>
           <td></td>
           <td>Barang / Subcont</td>
           <td>Jumlah Kirim</td>
           <td></td>
         </tr>
         <tbody id="container">
           
         </tbody>
       </table>
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

<!-- modal -->
<div class="modal fade" id="modal-edit"> 
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Data Pengiriman</h4>
        <span class="pesan_validasi"></span>
        <span class="pesan_gagal"></span>
        <span class="pesan_sukses"></span>
      </div>

      <form id="form_edit">
      <div class="modal-body">
       <table class="table table-striped">
         <tr>
           <td>Subcont</td>
           <td>
            <input type="hidden" name="kode_pengiriman" id="kode_pengiriman_edit">
             <select name="kode_subcont_edit" id="kode_subcont_edit" class="form-control select2" style="width: 100%;" required>
               <option value="">--PILIH--</option>
             </select>
           </td>
         </tr>
         <tr>
           <td>Tanggal</td>
           <td><input type="text" name="tanggal_kirim_edit" id="tanggal_kirim_edit" class="form-control datepicker" required></td>
         </tr>
         <tr>
           <td>Perkiraan Tiba</td>
           <td><input type="text" name="tanggal_tiba_edit" id="tanggal_tiba_edit" class="form-control datepicker" required></td>
         </tr>
       </table>
       <span><input type="button" name="add_btn" value="+add" id="add_btn_edit" class="btn btn-xs btn-success"></span>
       <span id="data_detail"></span>
      </div>
      <div class="modal-footer">
        <div class="form-group" style="text-align: left;">
        <button type="button" class="btn btn-primary btn-sm" id="btn_edit" onclick="update_data(this);validasi_edit(this)" style="width: 150px;">Update</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
var count = 0;
var no = 0;
  // mixer pg
  $("#add_btn").click(function(){
    count += 1;
    no++;
    var i=$('#customFields tr').length;

      $('#container').append(
      '<tr class="records">'
        + '<td>'+i+'</td>' 

        + '<td><select name="barang_add[]" class="form-control select2" id="barang_'+i+'" style="width: 100%;" required>'
        + '<option value="">--PILIH--</option>'
        <?php foreach ($barang_data as $brg) { ?>
        +'<option value="<?php echo $brg->kode_barang ?>"><?php echo $brg->nama_barang ?></option>'
        <?php } ?>
        + '</select></td>'

        + '<td><input type="text" name="jumlah_kirim[]" id="jumlah_kirim_'+i+'" class="form-control" required autocomplete="off" style="width:90px;" onkeypress="return hanyaAngka(event)"></td>'
        + '<td><a href="javascript:void(0);" id="remCF"><span class="btn btn-danger">Batal</span></a>'
        +'</tr>'
      );

          $(".datepicker").datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          changeMonth: true,
          changeYear: true,
          orientation: "top",
          autoclose: true,
          todayHighlight: true,
          toggleActive: true,
          });

          $(".select2").select2({
            dropdownAutoWidth : true,
            allowClear:true,
            placeholder: 'Pilih',
            required : true
          });
      });

      $("#customFields").on('click', '#remCF', function(){
        $(this).parent().parent().remove();
      });


  var table;
  table = $('#data_pengiriman').DataTable({ 
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "info"      : true,
    "lengthChange": false,
    "ordering": false,
    "order": [], //Initial no order.

    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('c_pengiriman/list_data_pengiriman')?>",
      "type": "POST",
      "data": function (data) 
      {
        data.barang = $('#barang').val();
        data.date1 = $('#date1').val();
        data.date2 = $('#date2').val();
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
  $("#data_pengiriman_filter").css("display","none");


  $("#form_input").validate({
    rules: {
      subcont_add   : "required",
      tanggal_kirim : "required",
      tanggal_tiba  : "required",
    },
    messages: {
      subcont_add   : "<font color='red'>Subcont Harus Diisi</font>",
      tanggal_kirim : "<font color='red'>Tanggal Kirim Harus Diisi</font>",
      tanggal_tiba  : "<font color='red'>tanggal tiba Harus Diisi</font>",
    }
  })

  $('#btn_input').click(function() {
    $("#form_input").valid();
  });


   $("#form_edit").validate({
    rules: {
      kode_subcont_edit  : "required",
      tanggal_kirim_edit : "required",
      tanggal_tiba_edit  : "required",
    },
    messages: {
      kode_subcont_edit  : "<font color='red'>Subcont Harus Diisi</font>",
      tanggal_kirim_edit : "<font color='red'>Tanggal Kirim Harus Diisi</font>",
      tanggal_tiba_edit  : "<font color='red'>Tanggal Tiba Harus Diisi</font>",
    }
  })

  $('#btn_edit').click(function() {
    $("#form_edit").valid();
  });

  function validasi()
  {
    let valid_barang = document.getElementsByName('barang_add[]');
    for (i=0; i<valid_barang.length; i++)
      {
       if (valid_barang[i].value == "")
        {
         alert('Barang Harus Diisi');    
         return false;
        }
      }

    let valid_kirim = document.getElementsByName('jumlah_kirim[]');
    for (i=0; i<valid_kirim.length; i++)
      {
       if (valid_kirim[i].value == "")
        {
         alert('jumlah kirim Harus Diisi');    
         return false;
        }
      }
  }

  function simpan_data()
  {
    validasi();
    $.ajax({
      url   : "<?php echo base_url('c_pengiriman/simpan_data')?>",
      type  : "POST",
      data  : $("#form_input").serialize(),
      success : function(data)
      {
        let json  = data,
        obj       = JSON.parse(json);
        $(".pesan_validasi").show();
        $(".pesan_gagal").show();
        $(".pesan_sukses").show();

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
          $(".pesan_validasi").hide();
          $(".pesan_gagal").hide();
          $(".pesan_sukses").hide();
        }, 5000)
      }
    })
  }

  <?php for ($i=1; $i <=20 ; $i++) { ?>
  function hapus_data_<?php echo $i ?>()
  {
    let kode = $("#hapus_id_<?php echo $i ?>").val();
    $.ajax({
      url   : "<?php echo base_url('c_pengiriman/hapus_data/')?>"+kode,
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
    url   : "<?php echo base_url('c_pengiriman/edit_data/')?>"+kode,
    success : function(data)
    {
       let json  = data,
          obj       = JSON.parse(json);
          $("#kode_pengiriman_edit").val(obj.kode_pengiriman);
          $("#kode_subcont_edit").html(obj.kode_subcont);
          $("#tanggal_kirim_edit").val(obj.tanggal_kirim);
          $("#tanggal_tiba_edit").val(obj.tanggal_tiba);
          $("#data_detail").html(obj.tabel_data);
          $("#modal-edit").modal('show');
    }
    })
  }
  <?php } ?>


  function validasi_edit()
  {
    let valid_barang_edit = document.getElementsByName('barang_edit[]');
    for (i=0; i<valid_barang_edit.length; i++)
      {
       if (valid_barang_edit[i].value == "")
        {
         alert('Barang Harus Diisi');    
         return false;
        }
      }

    let valid_kirim_edit = document.getElementsByName('jumlah_kirim_edit[]');
    for (i=0; i<valid_kirim_edit.length; i++)
      {
       if (valid_kirim_edit[i].value == "")
        {
         alert('jumlah kirim Harus Diisi');    
         return false;
        }
      }

  }


  function update_data()
  {
   
    $.ajax({
      url   : "<?php echo base_url('c_pengiriman/update_data')?>",
      type  : "POST",
      data  : $("#form_edit").serialize(),
      success : function(data)
      {
        let json  = data,
        obj       = JSON.parse(json);
        $(".pesan_validasi").show();
        $(".pesan_gagal").show();
        $(".pesan_sukses").show();

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
          $(".pesan_validasi").hide();
          $(".pesan_gagal").hide();
          $(".pesan_sukses").hide();
        }, 5000)
      }
    })
  }

</script>