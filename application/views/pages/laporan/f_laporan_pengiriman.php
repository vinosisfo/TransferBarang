<div class="content-wrapper"> 
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab"><span class="badge bg-blue">Laporan Pengiriman</span></a></li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="fa-icons">
              <div class="box">               
                <div class="box-body scrolltable">
                  <div class="table-responsive">
                    <form action="<?php echo base_url('C_laporan/laporan_pengiriman_view') ?>" method="post" id="form_lp">
                      <table id="data_barang" class="table table-striped" style="width: 50%;">
                        <thead>
                          <tr>
                            <td style="width: 10%;">Periode</td>
                            <td style="width: 1%;">:</td>
                            <td colspan="1" style="width: 20%;">
                              <input type="text" name="date1" readonly class="form-control datepicker" style="width: 100%;" value="<?php echo date("Y-m-01") ?>">
                            </td>
                            <td colspan="1" style="width: 20%;">
                              <input type="text" name="date2" readonly class="form-control datepicker" style="width: 100%;" value="<?php echo date("Y-m-d") ?>">
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 10%;">Subcont</td>
                            <td style="width: 1%;">:</td>
                            <td colspan="2" style="width: 50%;">
                              <select name="subcont" class="form-control select2" style="width: 100%;">
                                <option value="">--PILIH--</option>
                                <?php foreach ($subcont as $sbc) { ?>
                                  <option value="<?php echo $sbc->kode_subcont ?>"><?php echo $sbc->nama_subcont ?></option>
                                <?php } ?>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Barang</td>
                            <td>:</td>
                            <td colspan="2">
                              <select name="barang" class="form-control select2" style="width: 100%;">
                                <option value="">--PILIH--</option>
                                <?php foreach ($barang as $brg) { ?>
                                  <option value="<?php echo $brg->kode_barang ?>"><?php echo $brg->nama_barang ?></option>
                                <?php } ?>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="submit" name="view" class="btn btn-primary btn-sm" value="View" style="width: 100%;">
                            </td>
                          </tr>
                        </thead>
                      </table>
                    </form>
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
