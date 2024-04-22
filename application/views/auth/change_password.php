<body class="fp-page">
    <div class="fp-box">
        <div class="logo">
            <a href="javascript:void(0);"><b>SIMA</b></a>
            <small></small>
        </div>

        <div class="card">
            <div class="body">
                <form id="changepassword" method="POST">
                    <div class="msg">
                        Change Password
                        <br>
                        <?= $this->session->userdata('reset_email'); ?>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="New password"
                                required autofocus>
                        </div>
                    </div>

                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">RESET MY PASSWORD</button>

                </form>
            </div>
        </div>
    </div>