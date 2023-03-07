
<div class="row">
    <div class="col-sm-7">
        <div class="form-group">
            <input name="total_bayar" id="total_bayar" value="<?php echo $tot; ?>" type="hidden"  class="form-control">
            <input name="diskon" id="nilai_diskon" type="hidden"  class="form-control">
            <input name="total_bayar_diskon" id="total_diskon" type="hidden"  class="form-control">
        </div>
        <div class="form-group">
            <label>Bayar:</label>
            <input name="bayar" id="bayar"  type="text"  class="form-control">
        </div>
        <div class="form-group">
            <div id="nominal_bayar" class='font-weight-bold'></div>
        </div>
        <div class="form-group">
            <label>Kembali:</label>
            <input type="text" id="tampil_kembali" class="form-control" disabled>
            <input type="hidden" name="kembali" id="kembali" class="form-control">
        </div>
        <div class="form-group">
            <button  type="submit" id="buat_transaksi" name="buat_transaksi" class="btn btn-success btn-block" disabled><span class="text">Buat Transaksi</span></button>
        </div>
    </div>
</div>