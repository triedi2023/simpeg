<div class="form">
    <?php echo form_open("://", ["class" => "formdetailpegawaiwithoutlist form-horizontal", 'data-url' => site_url('master_pegawai/master_pegawai_pns/ubah_proses?id=' . $data_pegawai['TMPEGAWAI_ID'])]); ?>
    <div class="form-body">
        <!-- div class="form-group">
            <label class="control-label col-md-4">Eselon</label>
            <div class="col-md-4">
                <select name="eselon_id" id="field_cr_eselon_id" class="form-control" style="width: 100%">
                    <option value="">- Pilih -</option>
                    <?php // if (isset($list_eselon)): ?>
                        <?php // foreach ($list_eselon as $val): ?>
                            <?php
//                            $selec = '';
//                            if (isset($data_jabatan['TRESELON_ID']) && $val['ID'] == $data_jabatan['TRESELON_ID'])
//                                $selec = 'selected=""';
                            ?>
                            <option <?php // echo $selec ?> value="<?php // echo $val['ID'] ?>"><?php // echo $val['NAMA'] ?></option>
                        <?php // endforeach ?>
                    <?php // endif ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-4">Nama Jabatan (Ref.)</label>
            <div class="col-md-6">
                <select name="jabatan_id" id="field_cr_jabatan_id" class="form-control" style="width: 100%">
                    <option value="">- Pilih -</option>
                    <?php // if (isset($list_jabatan)): ?>
                        <?php // foreach ($list_jabatan as $val): ?>
                            <?php
//                            $selec = '';
//                            if (isset($data_jabatan['TRJABATAN_ID']) && $val['ID'] == $data_jabatan['TRJABATAN_ID'])
//                                $selec = 'selected=""';
                            ?>
                            <option <?php // echo $selec ?> value="<?php // echo $val['ID'] ?>"><?php // echo $val['NAMA'] ?></option>
                        <?php // endforeach ?>
                    <?php // endif ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-4">Nama Jabatan (Tanpa Ref.)</label>
            <div class="col-md-6">
                <input type="text" name="nama_jabatan" id="field_c_nama_jabatan" class="form-control" value="<?php // echo isset($data_jabatan['K_JABATAN_NOKODE']) ? $data_jabatan['K_JABATAN_NOKODE'] : set_value('nama_jabatan'); ?>" placeholder="Nama Jabatan (Tanpa Ref.)" />
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-4">Lokasi Kerja</label>
                    <div class="col-md-7">
                        <select name="trlokasi_id" id="field_c_trlokasi_id" data-edit="<?php // echo isset($data_jabatan['KDU1']) ? 1 : '' ?>" class="form-control struktur_lokasi" style="width: 100%">
                            <option value="">- Pilih Lokasi Kerja -</option>
                            <?php
//                            if (isset($data_jabatan['TRLOKASI_ID']) && !empty($data_jabatan['TRLOKASI_ID'])) {
//                                echo $list_lokasi;
//                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-4">Unit Jabatan Pimpinan Tinggi Madya</label>
                    <div class="col-md-7">
                        <select name="kdu1" id="field_c_kdu1" class="form-control struktur_kdu1" style="width: 100%">
                            <option value="">- Pilih Jabatan Pimpinan Tinggi Madya -</option>
                            <?php // if (isset($list_kdu1)): ?>
                                <?php // foreach ($list_kdu1 as $val): ?>
                                    <?php
//                                    $selec = '';
//                                    if (isset($data_jabatan['KDU1']) && $val['ID'] == $data_jabatan['KDU1'])
//                                        $selec = 'selected=""';
                                    ?>
                                    <option <?php // echo $selec ?> value="<?php // echo $val['ID'] ?>"><?php // echo $val['NAMA'] ?></option>
                                <?php // endforeach ?>
                            <?php // endif ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-4">Unit Jabatan Pimpinan Tinggi Pratama</label>
                    <div class="col-md-7">
                        <select name="kdu2" id="field_c_kdu2" class="form-control struktur_kdu2" style="width: 100%">
                            <option value="">- Pilih Jabatan Pimpinan Tinggi Pratama -</option>
                            <?php // if (isset($list_kdu2)): ?>
                                <?php // foreach ($list_kdu2 as $val): ?>
                                    <?php
//                                    $selec = '';
//                                    if (isset($data_jabatan['KDU2']) && $val['ID'] == $data_jabatan['KDU2'])
//                                        $selec = 'selected=""';
                                    ?>
                                    <option <?php // echo $selec ?> value="<?php // echo $val['ID'] ?>"><?php // echo $val['NAMA'] ?></option>
                                <?php // endforeach ?>
                            <?php // endif ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-4">Unit Jabatan Administrator</label>
                    <div class="col-md-7">
                        <select name="kdu3" id="field_c_kdu3" class="form-control struktur_kdu3" style="width: 100%">
                            <option value="">- Pilih Jabatan Administrator -</option>
                            <?php // if (isset($list_kdu3)): ?>
                                <?php // foreach ($list_kdu3 as $val): ?>
                                    <?php
//                                    $selec = '';
//                                    if (isset($data_jabatan['KDU3']) && $val['ID'] == $data_jabatan['KDU3'])
//                                        $selec = 'selected=""';
                                    ?>
                                    <option <?php // echo $selec ?> value="<?php // echo $val['ID'] ?>"><?php // echo $val['NAMA'] ?></option>
                                <?php // endforeach ?>
                            <?php // endif ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-4">Unit Pengawas</label>
                    <div class="col-md-7">
                        <select name="kdu4" id="field_c_kdu4" class="form-control struktur_kdu4" style="width: 100%">
                            <option value="">- Pilih Pengawas -</option>
                            <?php // if (isset($list_kdu4)): ?>
                                <?php // foreach ($list_kdu4 as $val): ?>
                                    <?php
//                                    $selec = '';
//                                    if (isset($data_jabatan['KDU4']) && $val['ID'] == $data_jabatan['KDU4'])
//                                        $selec = 'selected=""';
                                    ?>
                                    <option <?php // echo $selec ?> value="<?php // echo $val['ID'] ?>"><?php // echo $val['NAMA'] ?></option>
                                <?php // endforeach ?>
                            <?php // endif ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-4">Unit Pelaksana (Eselon V)</label>
                    <div class="col-md-7">
                        <select name="kdu5" id="field_c_kdu5" class="form-control struktur_kdu5" style="width: 100%">
                            <option value="">- Pilih Pelaksana (Eselon V) -</option>
                            <?php // if (isset($list_kdu5)): ?>
                                <?php // foreach ($list_kdu5 as $val): ?>
                                    <?php
//                                    $selec = '';
//                                    if (isset($data_jabatan['KDU5']) && $val['ID'] == $data_jabatan['KDU5'])
//                                        $selec = 'selected=""';
                                    ?>
                                    <option <?php // echo $selec ?> value="<?php // echo $val['ID'] ?>"><?php // echo $val['NAMA'] ?></option>
                                <?php // endforeach ?>
                            <?php // endif ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-4">Unit Kerja (Tanpa Kode Referensi)</label>
                    <div class="col-md-7">
                        <input type="text" name="unitkerjanokoderef" id="field_c_unitkerjanokoderef" class="form-control" value="<?php // echo isset($data_jabatan['NMUNIT']) ? $data_jabatan['NMUNIT'] : set_value('unitkerjanokoderef'); ?>" placeholder="Unit Kerja (Tanpa Kode Referensi)" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">&nbsp;</div>
            <div class="col-md-12">&nbsp;</div>
        </div -->
        <div class="row">
            <div class="col-md-12">
                <div class="tabbable-custom nav-justified">
                    <ul class="nav nav-tabs nav-justified">
                        <!-- li class="active">
                            <a href="#tab_1_1_1" data-toggle="tab" aria-expanded="true"> Surat Keputusan </a>
                        </li -->
                        <li class="active">
                            <a href="#tab_1_1_2" data-toggle="tab" aria-expanded="false"> Surat Tanda Lulus Kesehatan </a>
                        </li>
                        <li>
                            <a href="#tab_1_1_3" data-toggle="tab" aria-expanded="false"> SKCK </a>
                        </li>
                        <li>
                            <a href="#tab_1_1_4" data-toggle="tab" aria-expanded="false"> Surat Bebas NAPZA </a>
                        </li>
                        <li class="">
                            <a href="#tab_1_1_5" data-toggle="tab" aria-expanded="false"> Surat Tanda Lulus Pra Jabatan </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- div class="tab-pane active" id="tab_1_1_1">
                            <div class="form-body form-horizontal">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Nomor</label>
                                            <div class="col-md-8">
                                                <input type="text" name="no_sk" maxlength="100" id="field_c_no_sk" class="form-control" value="<?php // echo isset($data_jabatan['NO_SK']) ? $data_jabatan['NO_SK'] : set_value('no_sk'); ?>" placeholder="No SK" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">TMT Jabatan</label>
                                            <div class="col-md-8">
                                                <input type="text" name="tmt_jabatan" id="field_c_tmt_jabatan" class="form-control" value="<?php // echo isset($data_jabatan['TMT_JABATAN2']) ? $data_jabatan['TMT_JABATAN2'] : set_value('tmt_jabatan'); ?>" placeholder="Tmt jabatan" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Tanggal</label>
                                            <div class="col-md-8">
                                                <input type="text" name="tgl_sk" id="field_c_tgl_sk" class="form-control" value="<?php // echo isset($data_jabatan['TGL_SK2']) ? $data_jabatan['TGL_SK2'] : set_value('tgl_sk'); ?>" placeholder="Tgl SK" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Pejabat</label>
                                            <div class="col-md-8">
                                                <input type="text" name="pejabat_sk" maxlength="100" id="field_c_pejabat_sk" class="form-control" value="<?php echo isset($data_jabatan['PEJABAT_SK']) ? $data_jabatan['PEJABAT_SK'] : set_value('pejabat_sk'); ?>" placeholder="Pejabat SK" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">SK</label>
                                            <div class="col-md-8">
                                                <input type="file" name="doc_sk" id="field_c_doc_sk" class="form-control" value="" placeholder="Dokumen SK" />
                                                <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                                            </div>
                                            <?php // if (!empty($data_jabatan['DOC_SKJABATAN']) && $data_jabatan['DOC_SKJABATAN'] <> '') { ?>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-url="<?php // echo site_url('master_pegawai/master_pegawai_jabatan/view_dokumen?id='.$data_jabatan['ID']); ?>" target="_blank" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            <?php // } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div -->
                        <div class="tab-pane active" id="tab_1_1_2">
                            <div class="form-body form-horizontal">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Nomor</label>
                                            <div class="col-md-8">
                                                <input type="text" name="no_stlk" maxlength="100" id="field_c_no_stlk" class="form-control" value="<?php echo isset($data_pegawai['NO_STLK']) ? $data_pegawai['NO_STLK'] : set_value('no_stlk'); ?>" placeholder="No STLK" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Tanggal</label>
                                            <div class="col-md-8">
                                                <input type="text" name="tgl_stlk" id="field_c_tgl_stlk" class="form-control" value="<?php echo isset($data_pegawai['TGL_STLK2']) ? $data_pegawai['TGL_STLK2'] : set_value('tgl_stlk'); ?>" placeholder="Tgl STLK" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Rumah Sakit</label>
                                            <div class="col-md-8">
                                                <input type="text" name="rs" maxlength="50" id="field_c_rs" class="form-control" value="<?php echo isset($data_pegawai['RUMAH_SAKIT']) ? $data_pegawai['RUMAH_SAKIT'] : set_value('rs'); ?>" placeholder="Rumah Sakit" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Pejabat</label>
                                            <div class="col-md-8">
                                                <input type="text" name="pejabat_stlk" maxlength="100" id="field_c_pejabat_stlk" class="form-control" value="<?php echo isset($data_pegawai['PEJABAT_STLK']) ? $data_pegawai['PEJABAT_STLK'] : set_value('pejabat_stlk'); ?>" placeholder="Pejabat" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Surat</label>
                                            <div class="col-md-8">
                                                <input type="file" name="doc_stlk" id="field_c_doc_sk" class="form-control" value="" placeholder="Dokumen STLK" />
                                                <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                                            </div>
                                            <?php if (!empty($data_pegawai['DOC_STLK']) && $data_pegawai['DOC_STLK'] <> '') { ?>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_pns/view_dokumen?id='.$data_pegawai['TMPEGAWAI_ID']); ?>" target="_blank" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_1_3">
                            <div class="form-body form-horizontal">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Nomor</label>
                                            <div class="col-md-8">
                                                <input type="text" name="no_skck" maxlength="100" id="field_c_no_skck" class="form-control" value="<?php echo isset($data_pegawai['NO_SKCK']) ? $data_pegawai['NO_SKCK'] : set_value('no_skck'); ?>" placeholder="No SKCK" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Tanggal</label>
                                            <div class="col-md-8">
                                                <input type="text" name="field_c_tgl_skck" id="field_c_tgl_skck" class="form-control" value="<?php echo isset($data_pegawai['TGL_SKCK']) ? $data_pegawai['TGL_SKCK'] : set_value('field_c_tgl_skck'); ?>" placeholder="Tgl SKCK" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Surat</label>
                                            <div class="col-md-8">
                                                <input type="file" name="doc_skck" id="field_c_doc_skck" class="form-control" value="" placeholder="Dokumen SKCK" />
                                                <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                                            </div>
                                            <?php if (!empty($data_pegawai['DOC_SKCK']) && $data_pegawai['DOC_SKCK'] <> '') { ?>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_pns/view_dokumen?id='.$data_pegawai['TMPEGAWAI_ID']); ?>" target="_blank" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_1_4">
                            <div class="form-body form-horizontal">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Nomor</label>
                                            <div class="col-md-8">
                                                <input type="text" name="no_napza" maxlength="100" id="field_c_no_napza" class="form-control" value="<?php echo isset($data_pegawai['NO_NAPZA']) ? $data_pegawai['NO_NAPZA'] : set_value('no_napza'); ?>" placeholder="No SKCK" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Tanggal</label>
                                            <div class="col-md-8">
                                                <input type="text" name="field_c_tgl_napza" id="field_c_tgl_napza" class="form-control" value="<?php echo isset($data_pegawai['TGL_NAPZA']) ? $data_pegawai['TGL_NAPZA'] : set_value('field_c_tgl_napza'); ?>" placeholder="Tgl SKCK" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Surat</label>
                                            <div class="col-md-8">
                                                <input type="file" name="doc_napza" id="field_c_doc_napza" class="form-control" value="" placeholder="Dokumen Napza" />
                                                <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                                            </div>
                                            <?php if (!empty($data_pegawai['DOC_NAPZA']) && $data_pegawai['DOC_NAPZA'] <> '') { ?>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_pns/view_dokumen?id='.$data_pegawai['TMPEGAWAI_ID']); ?>" target="_blank" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze popupfull">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_1_5">
                            <div class="form-body form-horizontal">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Nama Diklat</label>
                                            <div class="col-md-8">
                                                <input type="text" name="nama_prajab" maxlength="255" id="field_c_nama_prajab" class="form-control" value="<?php echo isset($data_prajab['NAMA_DIKLAT']) ? $data_prajab['NAMA_DIKLAT'] : set_value('nama_prajab'); ?>" placeholder="Nama" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Nomor</label>
                                            <div class="col-md-8">
                                                <input type="text" name="no_prajab" maxlength="100" id="field_c_no_prajab" class="form-control" value="<?php echo isset($data_prajab['NO_STTPP']) ? $data_prajab['NO_STTPP'] : set_value('no_prajab'); ?>" placeholder="No" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Tanggal SK</label>
                                            <div class="col-md-8">
                                                <input type="text" name="tgl_prajab" id="field_c_tgl_prajab" class="form-control" value="<?php echo isset($data_prajab['TGL_STTPP2']) ? $data_prajab['TGL_STTPP2'] : set_value('tgl_prajab'); ?>" placeholder="Tgl" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Pejabat</label>
                                            <div class="col-md-8">
                                                <input type="text" name="pejabat_prajab" maxlength="100" id="field_c_pejabat_prajab" class="form-control" value="<?php echo isset($data_prajab['PJBT_STTPP']) ? $data_prajab['PJBT_STTPP'] : set_value('pejabat_prajab'); ?>" placeholder="Pejabat" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Dokumen</label>
                                            <div class="col-md-8">
                                                <input type="file" name="doc_prajab" id="field_c_doc_sk" class="form-control" value="" placeholder="Dokumen" />
                                                <span class="help-block text-danger"><b>Document Yang Di Upload Harus Format pdf dan Maximal ukuran file 2Mb.</b></span>
                                            </div>
                                            <?php if (!empty($data_prajab['DOC_PRAJABATAN']) && $data_prajab['DOC_PRAJABATAN'] <> '') { ?>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-url="<?php echo site_url('master_pegawai/master_pegawai_diklat_prajabatan/view_dokumen?id='.$data_prajab['TMPEGAWAI_ID']); ?>" target="_blank" title="Lihat Dokumen" class="btn btn-circle btn-icon-only green-haze">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div -->

    <?php if ($this->session->userdata('idgroup') != '' && $this->session->userdata('idgroup') != '3') { ?>
    <div class="form-actions">
        <div class="pull-left">
            <button type="button" class="btn default"><i class="fa fa-close"></i> Batal</button>
        </div>
        <div class="pull-right">
            <button type="submit" class="btn btn-warning btn-circle blue-chambray"><i class="fa fa-check"></i> Simpan</button>
        </div>
    </div>
    <?php } ?>
    <?php echo form_close(); ?>
</div>
<script>
    <?php if (isset($data_jabatan['TRLOKASI_ID'])) { ?>
        $("select#field_c_trlokasi_id").select2({allowClear: true});
    <?php } else { ?>
        $("select#field_c_trlokasi_id").select2({
            data: <?php echo $list_lokasi ?>,
            allowClear: true
        });
    <?php } ?>
    $("select#field_cr_eselon_id").select2();
    $("select#field_cr_jabatan_id").select2();
    $("select#field_c_kdu1").select2();
    $("select#field_c_kdu2").select2();
    $("select#field_c_kdu3").select2();
    $("select#field_c_kdu4").select2();
    $("select#field_c_kdu5").select2();
    $("input#field_c_tgl_sk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_c_tmt_jabatan").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_c_tgl_stlk").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
    $("input#field_c_tgl_prajab").datepicker({autoclose: true, language: "id", todayHighlight: true, format: 'dd/mm/yyyy', endDate: new Date('<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))) ?>')}).inputmask("99/99/9999", {placeholder: 'DD/MM/YYYY'});
</script>