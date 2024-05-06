<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
        <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>">
        <?php if ($this->session->flashdata('pesan')) { ?>

        <?php } ?>
            <div class="col-xs-12 col-sm-9">
                <div class="card">
                    <div class="body">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab"
                                        data-toggle="tab">Profile</a></li>
                                <li role="presentation"><a href="#profile_settings" aria-controls="settings" role="tab"
                                        data-toggle="tab">Edit Profile</a></li>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="home">
                                    <div class="panel panel-default panel-post">
                                        <div class="panel-heading">
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#">
                                                        <img src="<?= base_url('assets/'); ?>images/user.png" />
                                                    </a>
                                                </div>
                                                <?php
                                                foreach ($user as $u) : ?>

                                                <?php $this->session->set_userdata('referred_from', current_url()); ?>
                                                <div class="media-body">
                                                    <h4 class="media-heading">
                                                        <a><?= $this->session->userdata('username'); ?></a>
                                                    </h4>
                                                    <li>Nama Lengkap : <a><?= $u['nama_user']; ?></a></li>
                                                    <li>Divisi : <a><?= $u['divisi']; ?></a></li>
                                                    

                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                                <?php
                                foreach ($user as $u) : ?>
                                <div role="tabpanel" class="tab-pane fade in" id="profile_settings">
                                    <form class="form-horizontal"
                                        action="<?= base_url() ?>user/fungsi_edit/<?= $u['id_user']; ?>" method="post"
                                        enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="NameSurname" class="col-sm-2 control-label">Divisi</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" placeholder="Username"
                                                        value="<?= $u['divisi']; ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="NameSurname" class="col-sm-2 control-label">Username</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" placeholder="Username"
                                                        value="<?= $u['username']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="Nama" class="col-sm-2 control-label">Nama Lengkap</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" id="nama_user" name="nama_user"
                                                        placeholder="Nama Lengkap" value="<?= $u['nama_user']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">EDIT</button>
                                            </div>
                                        </div>


                                    </form>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>