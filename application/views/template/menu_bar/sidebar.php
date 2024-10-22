<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
        <p><?php echo $this->session->userdata['username'] ?></p>
          <a href="#"><h4>MENU UTAMA</h4></a>
        
        </div>
        <div class="pull-left info">
         
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Setting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('c_user')?>"><i class="fa fa-circle-o"></i>Data user</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-list"></i> <span>master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <?php if(($this->session->userdata('level')==='ADMIN PPIC') or ($this->session->userdata('level')==='GUDANG')){ ?>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('C_barang')?>"><i class="fa fa-circle-o"></i> Data Barang</a></li>
            <li><a href="<?php echo base_url('C_subcont')?>"><i class="fa fa-circle-o"></i> Data Subcont</a></li>
          </ul>
        <?php } ?>
        </li>

         <li class="treeview">
          <a href="#">
            <i class="fa fa-list"></i> <span>Transaksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <?php if($this->session->userdata('level')==='ADMIN PPIC'){ ?>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('c_pengiriman')?>"><i class="fa fa-circle-o"></i>Pengiriman Subcont</a></li>
            <li><a href="<?php echo base_url('c_retur')?>"><i class="fa fa-circle-o"></i>Retur Subcont</a></li>
            <li><a href="<?php echo base_url('c_penerimaan')?>"><i class="fa fa-circle-o"></i>Penerimaan Subcont</a></li>
          </ul>
        <?php } ?>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-list"></i> <span>laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('C_laporan/laporan_pengiriman')?>"><i class="fa fa-circle-o"></i>Laporan Pengiriman</a></li>
            <li><a href="<?php echo base_url('C_laporan/laporan_retur')?>"><i class="fa fa-circle-o"></i>Laporan retur</a></li>
            <li><a href="<?php echo base_url('C_laporan/laporan_penerimaan')?>"><i class="fa fa-circle-o"></i>Laporan penerimaan</a></li>
            <li><a href="<?php echo base_url('C_laporan/laporan_stok')?>"><i class="fa fa-circle-o"></i>Laporan stok</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
<!-- <div class="control-sidebar-bg"></div>
</div> -->