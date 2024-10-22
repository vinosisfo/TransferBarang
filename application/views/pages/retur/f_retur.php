<div class="content-wrapper"> 
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab"><span class="badge bg-blue">List Data Retur</span></a></li>
            <li><a href="#" data-toggle="modal" data-target="#modal-default"><span class="badge bg-red">Input Data Retur</span></a></li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="fa-icons">
              <div class="box">
                <div class="panel-body">
                     <form id="form-filter" method='post' class="form-horizontal">
                      <table class="table table-striped table-responsive" style="width: 100%; table-layout: auto; padding-bottom: 0px;">
                        <tr>
                          <td style="width: 10%;">Kode Pengiriman</td>
                          <td style="width: 20%;">
                            <input type="text" name="pengiriman" id="pengiriman" class="form-control">
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
                    <table id="data_retur" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Kode Retur</th>
                          <th>Tanggal Retur</th>
                          <th>Subcont</th>
                          <th>Nama Barang</th>
                          <th>Jumlah kirim</th>
                          <th>Jumlah Retur</th>   
                          <th>Print</th>         
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
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Input Data Retur</h4>
        <span class="pesan_validasi"></span>
        <span class="pesan_gagal"></span>
        <span class="pesan_sukses"></span>
      </div>

      <form id="form_input">
      <div class="modal-body">
       <table class="table table-striped">
         <tr>
           <td>Kode Pengiriman</td>
           <td>
            <span id="pesan_kirim"></span>
             <select name="pengiriman_add" id="pengiriman_add" class="form-control select2" onchange="pengiriman(this);" style="width: 100%;" required>
               <option value="">--PILIH--</option>
               <?php foreach ($data_pengiriman as $pgr) { ?>
                 <option value="<?php echo $pgr->kode_pengiriman ?>"><?php echo $pgr->kode_pengiriman ?></option>
               <?php } ?>
             </select>
             
           </td>
         </tr>
         <tr>
           <td>Subcont</td>
           <td><input type="text" readonly name="nama_subcont" id="nama_subcont" class="form-control" style="width: 100%;"></td>
         </tr>
         <tr>
           <td>Tanggal</td>
           <td><input type="text" readonly name="tgl_kirim" id="tgl_kirim" class="form-control datepicker" required></td>
         </tr>
         <tr>
           <td>Perkiraan Tiba</td>
           <td><input type="text" readonly name="tgl_tiba" id="tgl_tiba" class="form-control datepicker" required></td>
         </tr>
       </table>
       <span id="tombol">
        <!-- <input type="button" name="add_btn" value="+add" id="add_btn" class="btn btn-xs btn-success"> -->
      </span>
       <table class="table table-striped table-bordered" id="customFields">
         <tr>
           <td style="width: 50px;"></td>
           <td style="width: 200px;">Barang</td>
           <td style="width: 50px;">Jumlah Kirim</td>
           <td style="width: 50px;">Jumlah retur</td>
           <td style="width: 200px;">Keterangan</td>
           <td style="width: 50px;"></td>
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

<script type="text/javascript">
  // $("#add_btn").click(function(){
    function add_row()
    {
    data_barang();
    var i=$('#customFields tr').length;

      $('#container').append(
      '<tr class="records">'
        + '<td>'+i+'</td>' 

        + '<td><select name="barang_add[]" class="form-control select2" id="barang_'+i+'" onchange="dt_kirim_'+i+'(this)" style="width: 100%;" required>'
        + '<option value="">--PILIH--</option>'
        + '</select></td>'

        + '<td><input type="text" name="jumlah_kirim[]" readonly id="jumlah_kirim_'+i+'" class="form-control" required autocomplete="off" style="width:90px;" onkeypress="return hanyaAngka(event)"></td>'

        + '<td><input type="text" name="jumlah_retur[]" id="jumlah_retur_'+i+'" class="form-control" required autocomplete="off" style="width:90px;" onkeypress="return hanyaAngka(event)" onkeyup="valid_retur_'+i+'(this)"><span id="pesan_'+i+'"></span></td>'

        + '<td><textarea name="Keterangan[]" maxlength="200" class="form-control" required style="height:37px; width:100%;"></textarea></td>'

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

          function data_barang()
          {
            let pengiriman_add = $("#pengiriman_add").val();
            if(pengiriman_add.trim()=='')
            {
              let pesan_kirim = '<font color="red">PILIH KODE PENGIRIMAN</font>';
              $("#pesan_kirim").html(pesan_kirim);
              console.log(pesan_kirim);
            }
            else
            {
              $.ajax({
                url : "<?php echo base_url('c_retur/data_barang/')?>"+pengiriman_add,
                success : function(data){
                  brg = data,
                  obj = JSON.parse(brg);
                  $("#barang_"+i+"").html(obj.data_barang);
                }
              })
            }
          }
        }
      // });

      var row = $("#customFields").on('click', '#remCF', function(){
        $(this).parent().parent().remove();
      });
      function pengiriman()
      {
        $("#kode_kirim").hide();
        let kode_kirim = $("#pengiriman_add").val();
        $.ajax({
          url : "<?php echo base_url('c_retur/pengiriman')?>",
          type : "POST",
          data : {kode_kirim : kode_kirim},
          success : function(data)
          {
            json = data,
            obj = JSON.parse(json);
            $("#nama_subcont").val(obj.nama_subcont);
            $("#tgl_kirim").val(obj.tanggal_kirim);
            $("#tgl_tiba").val(obj.tgl_tiba);
            let tombol ='<input type="button" name="add_btn" value="+add" id="add_btn" onclick="add_row(this);" class="btn btn-xs btn-success">';
            $("#tombol").html(tombol);
          }
        })
      }
      <?php for ($i=1; $i <=100 ; $i++) {  ?>
      function dt_kirim_<?php echo $i ?>()
          {
            let id_dtkirim = $("#barang_<?php echo $i ?>").val();
            $.ajax({
              url : "<?php echo base_url('c_retur/data_kirim')?>",
              type : "POST",
              data : {id_kirim : id_dtkirim},
              success : function(data)
              {
                kirim = data,
                obj = JSON.parse(kirim);
                $("#jumlah_kirim_<?php echo $i ?>").val(obj.jumlah_kirim);
              }
            })
          }

          function valid_retur_<?php echo $i ?>()
          {
            let jumlah_kirim = Number($("#jumlah_kirim_<?php echo $i ?>").val());
            let jumlah_retur = Number($("#jumlah_retur_<?php echo $i ?>").val());

            if(jumlah_retur >= jumlah_kirim)
            {
            
              document.getElementById("jumlah_retur_<?php echo $i ?>").value = "";
              let pesan = "<font color='red'>jumlah tidak valid </font>";
              $("#pesan_<?php echo $i ?>").html(pesan);
              console.log(jumlah_kirim);
            }
          }
      <?php } ?>

 
  var table;
  table = $('#data_retur').DataTable({ 
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "info"      : true,
    "lengthChange": false,
    "ordering": false,
    "order": [], //Initial no order.

    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": "<?php echo site_url('c_retur/list_data_retur')?>",
      "type": "POST",
      "data": function (data) 
      {
        data.pengiriman = $('#pengiriman').val();
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
  $("#data_retur_filter").css("display","none");


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


  //  $("#form_edit").validate({
  //   rules: {
  //     kode_subcont_edit  : "required",
  //     tanggal_kirim_edit : "required",
  //     tanggal_tiba_edit  : "required",
  //   },
  //   messages: {
  //     kode_subcont_edit  : "<font color='red'>Subcont Harus Diisi</font>",
  //     tanggal_kirim_edit : "<font color='red'>Tanggal Kirim Harus Diisi</font>",
  //     tanggal_tiba_edit  : "<font color='red'>Tanggal Tiba Harus Diisi</font>",
  //   }
  // })

  // $('#btn_edit').click(function() {
  //   $("#form_edit").valid();
  // });

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

    let valid_retur = document.getElementsByName('jumlah_retur[]');
    for (i=0; i<valid_retur.length; i++)
      {
       if (valid_retur[i].value == "")
        {
         alert('jumlah retur Harus Diisi');    
         return false;
        }
      }


    let valid_keterangan = document.getElementsByName('Keterangan[]');
    for (i=0; i<valid_keterangan.length; i++)
      {
       if (valid_keterangan[i].value == "")
        {
         alert('Keterangan retur Harus Diisi');    
         return false;
        }
      }
  }

  function simpan_data()
  {
    validasi();
    $.ajax({
      url   : "<?php echo base_url('c_retur/simpan_data')?>",
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
      url   : "<?php echo base_url('c_retur/hapus_data/')?>"+kode,
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