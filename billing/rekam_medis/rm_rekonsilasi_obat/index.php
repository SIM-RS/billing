<?php
//session_start();
include("../../sesi.php");
?>
<?php
//session_start();
$userId = $_SESSION['userId'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}

?>
<?php
session_start();
//include '../koneksi/konek.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <link rel="icon" href="../favicon.png">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <script src="../js/jquery-3.5.1.slim.js"></script>
          <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"> 
        <script src="../js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../../theme/tab-view.css" />
        <script type="text/javascript" src="../../theme/js/tab-view.js"></script>
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
  
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="../../theme/tab-view.css" />
        <script type="text/javascript" src="../../theme/js/tab-view.js"></script>
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
    <script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="javascript" src="../../loket/jquery.maskedinput.js"></script>
        <!--script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <!--dibawah ini diperlukan untuk menampilkan menu dropdown-->
    <script language="JavaScript" src="../../theme/js/mm_menu.js"></script>
        <!--<script language="JavaScript" src="../theme/js/dropdown.js"></script>-->
       

    <link rel="stylesheet" type="text/css" href="jquery_multiselect/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="jquery_multiselect/style.css" />

        <link rel="stylesheet" type="text/css" href="jquery_multiselect/jquery-ui.css" />
        <!--<script type="text/javascript" src="jquery_multiselect/jquery.js"></script>-->
        <script type="text/javascript" src="jquery_multiselect/jquery-ui.min.js"></script>
        <script type="text/javascript" src="jquery_multiselect/src/jquery.multiselect.js"></script>
    
        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../../theme/prototype.js"></script>
        <script type="text/javascript" src="../../theme/effects.js"></script>
        <script type="text/javascript" src="../../theme/popup.js"></script>
        <style type="text/css">

          .trdata:hover{
            background-color: #FFFF75;
          }
          td{
            text-align: center;
          }
          th{
               text-align: center;
          }
        </style>
        <title>Rekonsilasi obat</title>
    
    </head>
<body>
  
   <div  style="background-color: #EAF0F0 ; width: 1000px; height: 520px; margin: auto;">
            
          <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2" align="center">
                <tbody><tr>
                    <td height="30" class="tblatas" style="text-align: left;">&nbsp;FORM REKONSILASI OBAT</td>
                    <td width="35" class="tblatas">
                        <a href="http://localhost:7777/simrs-pelindo/billing/">
                            <img alt="close" src="http://localhost:7777/simrs-pelindo/billing/icon/x.png" style="cursor: pointer" border="0" width="32">
                        </a>
                    </td>
                </tr>
            </tbody></table>
      </fieldset>
  <div class="content-wrapper">
<section class="content-header">
    <!-- judul teks h1 disini -->
  <hr>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <!-- judul teks h1 disini -->
          <div class="box-tools pull-left" style="float: right; margin-right: 25px;">
         
            <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah" data-toggle="modal" data-target="#tambahuser">
         
            
<a href="" class="tblBtn" onclick="window.reload()" style="text-decoration: none; color: black"><img src="http://localhost:7777/simrs-pelindo/billing/icon/back.png" width="20" align="absmiddle" >Refresh</a>
            
          </div>
        </div>
      </div>
        <div class="box-body">
          <div class="table-responsive22">
            <table border="1"  id="datatable"  width="1000"  style="background-color: white; border-color: grey; padding:0px; margin: 0px; font-size: 11px; margin: auto;">
              <thead  style="background-color: #5AC032; color: white;">
                <tr>
                  <th>No.</th>
                  <th>Tanggal</th>
                  <th>Nama Obat</th>
                   <th>Jumlah</th>
                  <th>Dosis</th>
                  <th>Rute</th>
                     <th>Nama Pengguna</th>
                     <th>Tindak Lanjut</th>
                     <th>Perubahan Aturan Pakai</th>
                  <th>Opsi</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                    $no = 1;
                           $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);
$halperpage = 5;

$page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
      
$mulai = ($page>1) ? ($page * $halperpage) - $halperpage : 0;

$result = mysql_query("SELECT * FROM rm_rekonsilasi_obat");

$total = mysql_num_rows($result);

$pages = ceil($total/$halperpage);            
      
$query = mysql_query("SELECT * FROM rm_rekonsilasi_obat LIMIT $mulai, $halperpage")or die(mysql_error);
      
$no = $mulai+1;


              $queryview = mysql_query('SELECT * FROM rm_rekonsilasi_obat',$konek);
                    while ($row = mysql_fetch_assoc($queryview)) {
                  ?>
                  <tr class="trdata">
                    <td><?php echo $no++;?></td>
                  <td><?php echo $row['tanggal'];?></td>
                    <td><?php echo $row['nama_obat'];?></td>
                    <td><?php echo $row['jumlah'];?></td>
                    <td><?php echo $row['dosis'];?></td>                    
                    <td><?php echo $row['rute'];?></td>
                    <td><?php echo $row['nama_pengguna'];?></td>
                    <td><?php echo $row['tindak_lanjut']; ?></td>
                    <td><?php echo $row['perubahan_aturan_pakai']; ?></td>
                    <td>
                      <!--<a href="../user/form_edituser.php?id=<?php echo $row['id_user']?>" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-pencil"></i> Edit</a>-->
                     <button class="tblBtn" type="button" id="tambah" name="tambah" value="simpan" onclick="simpan(this.value)" style="cursor: pointer;"data-toggle="modal" data-target="#updateuser<?php echo $no; ?>"><img src="http://localhost:7777/simrs-pelindo/billing/icon/edit.gif" width="10" align="absmiddle">&nbsp;&nbsp;Ubah</button>
                      <button class="tblBtn" type="button" id="delete" name="delete" value="hapus"  style="cursor: pointer;" data-toggle="modal" data-target="#deleteuser<?php echo $no; ?>"><img src="http://localhost:7777/simrs-pelindo/billing/icon/delete.gif" align="absmiddle" width="10">&nbsp;&nbsp;Hapus</button>
                    <a href="cetak_rekonsilasi_obat.php?act=serah&id=<?php echo $row['id']; ?>&idKunj=<?php echo $_REQUEST['idKunj'] ?>&idPel=<?php echo $_REQUEST['idPel'] ?>&idPasien=<?php echo $_REQUEST['idPasien'] ?>"  name="btnPrint" id="btnPrint"  class="tblCetak" style="text-decoration: none; color: black">&nbsp;&nbsp;&nbsp;Cetak</a>




                      <!-- modal delete -->
                      <div class="example-modal">
                        <div id="deleteuser<?php echo $no; ?>" class="modal fade" role="dialog" style="display:none;">
                          <div class="modal-dialog">
                            <div class="modal-content" style="border: 5px solid  #5AC032; background-color: #eaf0f0;">
                              <div class="modal-header" style="background-color: #5ac032;">
                 
                  <h4 class="modal-title" style="color: white;">Konfirmasi Hapus data</h4>
                              </div>
                              <div class="modal-body">
                                <h4 align="center" >Apakah anda yakin ingin menghapus data ini<strong><span class="grt"></span></strong> ?</h4>
                              </div>
                              <div class="modal-footer">
                                <button style="padding: 4px;" id="nodelete" type="button" class="tblBtn" data-dismiss="modal">Batal</button>
                                <a href="rekonsilasi_obat_utils.php?act=delete&id=<?php echo $row['id']; ?>&idKunj=<?php echo $_REQUEST['idKunj'] ?>&idPel=<?php echo $_REQUEST['idPel'] ?>&idPasien=<?php echo $_REQUEST['idPasien'] ?>" class="tblBtn" style="text-decoration: none; color: black; padding: 4px; " >Oke</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><!-- modal delete -->

                      <!-- modal update user -->
                      <div class="example-modal">
                        <div id="updateuser<?php echo $no; ?>" class="modal fade" role="dialog" style="display:none;">
                          <div class="modal-dialog">
                               <div class="modal-content" style="border: 5px solid  #5AC032; background-color: #eaf0f0;">
                <div class="modal-header" style="background-color: #5ac032;">
                                
                                <h4 class="modal-title" style="color: white;">Edit REKONSILASI OBAT</h4>
                                  <button type="button"  data-dismiss="modal" aria-label="Close" style="border: 0px;"><span aria-hidden="true"><img alt="close" src="http://localhost:7777/simrs-pelindo/billing/icon/x.png" width="32"></button>
                              </div>
                              <div class="modal-body">
                                <form action="rekonsilasi_obat_utils.php?act=update" method="post" role="form">
                                  <?php
                                      $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);
                                  $id = $row['id'];
                                  $query = "SELECT * FROM rm_rekonsilasi_obat WHERE id='$id' ";
                                  $result = mysql_query($query);
                                  while ($row = mysql_fetch_assoc($result)) {
                                  ?>
                         <input type="hidden" id="idKunj" name="idKunj" value="<?php echo $_REQUEST['idKunj'] ?>" required="">
   <input type="hidden" id="idPel" name="idPel" value="<?php echo $_REQUEST['idPel'] ?>" required="">
    <input type="hidden" id="idPasien" name="idPasien" value="<?php echo $_REQUEST['idPasien'] ?>" required="">
    <input type="hidden" id="userId" name="userId" value="<?php echo $_SESSION['userId'] ?>" required="">
                                    <input type="hidden" class="form-control" name="id" value="<?php echo $row['id']; ?>">
                                   <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Tanggal<span class="text-red">*</span></label>         
                      <div class="col-sm-8"> <input type="text" id="txtFilter" name="tanggal"  class="txtcenter" required=""value="<?php echo $row['tanggal']; ?>" /></div>
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Nama Obat<span class="text-red">*</span></label>         
                      <div class="col-sm-8"> <input id="txtFilter" type="text" name="nama_obat"  class="txtcenter" required="" value="<?php echo $row['nama_obat']; ?>"/></div>
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Jumlah<span class="text-red">*</span></label>         
                      <div class="col-sm-8"> <input id="txtFilter" type='number' name="jumlah"  class="txtcenter" required=""value="<?php echo $row['jumlah']; ?>" /></div>
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">dosis<span class="text-red">*</span></label>         
                      <div class="col-sm-8"><textarea name="dosis"><?php echo $row['dosis']; ?></textarea></div>
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Rute<span class="text-red">*</span></label>         
                      <div class="col-sm-8"> <input id="txtFilter" name="rute"  class="txtcenter" required="" value="<?php echo $row['rute']; ?>"/></div>
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Nama Pengguna<span class="text-red">*</span></label>         
                      <div class="col-sm-8"> <input id="txtFilter" name="nama_pengguna"  class="txtcenter" required="" value="<?php echo $row['nama_pengguna']; ?>"/></div>
                      </div>
                    </div>
                       <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Tindak Lanjut<span class="text-red">*</span></label>         
                      <div class="col-sm-8">
                        <select name="tindak_lanjut">
                          <option><?php echo $row['tindak_lanjut']; ?></option>
                          <option>Lanjut Aturan Pakai Sama</option>
                            <option>Lanjut Aturan Pakai Berubah</option>
                              <option>Stop</option>
                        </select>
                      </div>
                      </div>
                    </div>
                   <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Perubahan Aturan Pakai<span class="text-red">*</span></label>         
                      <div class="col-sm-8"><textarea name="perubahan_aturan_pakai"><?php echo $row['perubahan_aturan_pakai']; ?></textarea></div>
                      </div>
                    </div>
                                  <div class="modal-footer">  
                                      <button type="button" id="batal" name="batal" data-dismiss="modal" aria-label="Close" style="cursor: pointer;"><img src="http://localhost:7777/simrs-pelindo/billing/icon/back.png" width="20" align="absmiddle">&nbsp;&nbsp;Batal</button>
                     <button type="submit" id="tambah" name="submit" value="Update" onclick="simpan(this.value)" style="cursor: pointer;"><img src="http://localhost:7777/simrs-pelindo/billing/icon/add.gif" width="20" align="absmiddle">&nbsp;&nbsp;Tambah</button>
                                  </div>
                                  <?php
                                  }
                                  ?>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><!-- modal update user -->
                    </td>
                  </tr>
  
                  <?php
                    }
                  ?>
              </tbody>
            </table>
<hr>
          </div> 
        </div>
        <div class="row">
          <div class="col">
            <font color="#000066" face="arial" size="2">
   <?php echo "<b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Halaman ".$page."  Dari  ".$total."</b>";?>
</font>
</div>

      <div class="col" style="float: right;">
         <a  href="?halaman=<?php echo $page - 1; ?>&id=<?php echo $row['id']; ?>&idKunj=<?php echo $_REQUEST['idKunj'] ?>&idPel=<?php echo $_REQUEST['idPel'] ?>&idPasien=<?php echo $_REQUEST['idPasien'] ?>"> <img src="http://localhost:7777/simrs-pelindo/billing/icon/page_prev.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onclick="if (document.getElementById(&quot;gridbox&quot;).page>1){document.getElementById(&quot;gridbox&quot;).page=document.getElementById(&quot;gridbox&quot;).page-1;goFilterAndSort(&quot;gridbox&quot;);}"></a>

   <?php for ($i=1; $i<=$pages ; $i++){ ?>
<a  href="?halaman=<?php echo $i; ?>&id=<?php echo $row['id']; ?>&idKunj=<?php echo $_REQUEST['idKunj'] ?>&idPel=<?php echo $_REQUEST['idPel'] ?>&idPasien=<?php echo $_REQUEST['idPasien'] ?>"><img src="http://localhost:7777/simrs-pelindo/billing/icon/page_next.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onclick="if (document.getElementById(&quot;gridbox&quot;).page<document.getElementById(&quot;gridbox&quot;).maxpage){document.getElementById(&quot;gridbox&quot;).page=document.getElementById(&quot;gridbox&quot;).page+1;goFilterAndSort(&quot;gridbox&quot;);}"></a>
<?php } ?>
</div>

</div>
        <!-- modal insert -->
        <div class="example-modal">
          <div id="tambahuser" class="modal fade" role="dialog" style="display:none;">
            <div class="modal-dialog"> 
              <div class="modal-content" style="border: 5px solid  #5AC032; background-color: #eaf0f0;">
                <div class="modal-header" style="background-color: #5ac032;">
                 
                  <h4 class="modal-title" style="color: white;">Input REKONSILASI OBAT</h4>
                   <button type="button"  data-dismiss="modal" aria-label="Close" style="border: 0px;"><span aria-hidden="true"><img alt="close" src="http://localhost:7777/simrs-pelindo/billing/icon/x.png" width="32"></button>
              
                </div>
                <div class="modal-body">
                  <form action="rekonsilasi_obat_utils.php?act=tambah" method="post" role="form">
                    <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Tanggal<span class="text-red">*</span></label>         
                      <div class="col-sm-8"> <input type="date" id="txtFilter" name="tanggal"  class="txtcenter" required="" /></div>
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Nama Obat<span class="text-red">*</span></label>         
                      <div class="col-sm-8"> <input id="txtFilter" type="text" name="nama_obat"  class="txtcenter" required="" /></div>
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Jumlah<span class="text-red">*</span></label>         
                      <div class="col-sm-8"> <input id="txtFilter" type='number' name="jumlah"  class="txtcenter" required="" /></div>
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">dosis<span class="text-red">*</span></label>         
                      <div class="col-sm-8"><textarea name="dosis"></textarea></div>
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Rute<span class="text-red">*</span></label>         
                      <div class="col-sm-8"> <input id="txtFilter" name="rute"  class="txtcenter" required="" /></div>
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Nama Pengguna<span class="text-red">*</span></label>         
                      <div class="col-sm-8"> <input id="txtFilter" name="nama_pengguna"  class="txtcenter" required="" /></div>
                      </div>
                    </div>
                       <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Tindak Lanjut<span class="text-red">*</span></label>         
                      <div class="col-sm-8">
                        <select name="tindak_lanjut">
                          <option>Lanjut Aturan Pakai Sama</option>
                            <option>Lanjut Aturan Pakai Berubah</option>
                              <option>Stop</option>
                        </select>
                      </div>
                      </div>
                    </div>
                   <div class="form-group">
                      <div class="row">
                      <label class="col-sm-3 control-label text-right">Perubahan Aturan Pakai<span class="text-red">*</span></label>         
                      <div class="col-sm-8"><textarea name="perubahan_aturan_pakai"></textarea></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                  </label>
                        <div class="col-sm-8">
  <input type="hidden" id="idKunj" name="idKunj" value="<?php echo $_REQUEST['idKunj'] ?>" required="">
   <input type="hidden" id="idPel" name="idPel" value="<?php echo $_REQUEST['idPel'] ?>" required="">
    <input type="hidden" id="idPasien" name="idPasien" value="<?php echo $_REQUEST['idPasien'] ?>" required="">
    <input type="hidden" id="userId" name="userId" value="<?php echo $_SESSION['userId'] ?>" required="">
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="batal" name="batal" data-dismiss="modal" aria-label="Close" style="cursor: pointer;"><img src="http://localhost:7777/simrs-pelindo/billing/icon/back.png" width="20" align="absmiddle">&nbsp;&nbsp;Batal</button>
                     <button type="submit" id="tambah" name="tambah" value="tambah" onclick="simpan(this.value)" style="cursor: pointer;"><img src="http://localhost:7777/simrs-pelindo/billing/icon/add.gif" width="20" align="absmiddle">&nbsp;&nbsp;Tambah</button>
                  
                    </div>
                    <!--<div class="box-footer">
                      <a href="../user/data_user.php" class="btn btn-danger"><i class="fa fa-close"></i> Batal</a>
                      <input type="submit" name="submit" class="btn btn-primary" value="Simpan">
                    </div> /.box-footer -->
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div><!-- modal insert close -->
      </div>
    </div>
  </div>
</section><!-- /.content -->
</div>
<button id="updt" data-target="" data-toggle="modal" style="display:none"></button>
</body>
</html>
    
</body>

<?php if (isset($_REQUEST['modalUpdate'])): ?>

  <script>
    let idU = <?= $_GET['modalUpdate']; ?>;
    document.querySelector("#updt").dataset.target = "#updateuser" + idU;
    document.querySelector("#updt").click();
  </script>

<?php endif; ?>