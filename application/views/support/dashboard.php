 <!-- Right Sidebar -->
 <aside id="rightsidebar" class="right-sidebar">
     <ul class="nav nav-tabs tab-nav-right" role="tablist">
         <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
         <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
     </ul>
     <div class="tab-content">
         <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
             <ul class="demo-choose-skin">
                 <li data-theme="red" class="active">
                     <div class="red"></div>
                     <span>Red</span>
                 </li>
                 <li data-theme="pink">
                     <div class="pink"></div>
                     <span>Pink</span>
                 </li>
                 <li data-theme="purple">
                     <div class="purple"></div>
                     <span>Purple</span>
                 </li>
                 <li data-theme="deep-purple">
                     <div class="deep-purple"></div>
                     <span>Deep Purple</span>
                 </li>
                 <li data-theme="indigo">
                     <div class="indigo"></div>
                     <span>Indigo</span>
                 </li>
                 <li data-theme="blue">
                     <div class="blue"></div>
                     <span>Blue</span>
                 </li>
                 <li data-theme="light-blue">
                     <div class="light-blue"></div>
                     <span>Light Blue</span>
                 </li>
                 <li data-theme="cyan">
                     <div class="cyan"></div>
                     <span>Cyan</span>
                 </li>
                 <li data-theme="teal">
                     <div class="teal"></div>
                     <span>Teal</span>
                 </li>
                 <li data-theme="green">
                     <div class="green"></div>
                     <span>Green</span>
                 </li>
                 <li data-theme="light-green">
                     <div class="light-green"></div>
                     <span>Light Green</span>
                 </li>
                 <li data-theme="lime">
                     <div class="lime"></div>
                     <span>Lime</span>
                 </li>
                 <li data-theme="yellow">
                     <div class="yellow"></div>
                     <span>Yellow</span>
                 </li>
                 <li data-theme="amber">
                     <div class="amber"></div>
                     <span>Amber</span>
                 </li>
                 <li data-theme="orange">
                     <div class="orange"></div>
                     <span>Orange</span>
                 </li>
                 <li data-theme="deep-orange">
                     <div class="deep-orange"></div>
                     <span>Deep Orange</span>
                 </li>
                 <li data-theme="brown">
                     <div class="brown"></div>
                     <span>Brown</span>
                 </li>
                 <li data-theme="grey">
                     <div class="grey"></div>
                     <span>Grey</span>
                 </li>
                 <li data-theme="blue-grey">
                     <div class="blue-grey"></div>
                     <span>Blue Grey</span>
                 </li>
                 <li data-theme="black">
                     <div class="black"></div>
                     <span>Black</span>
                 </li>
             </ul>
         </div>
         <div role="tabpanel" class="tab-pane fade" id="settings">
             <div class="demo-settings">
                 <p>GENERAL SETTINGS</p>
                 <ul class="setting-list">
                     <li>
                         <span>Report Panel Usage</span>
                         <div class="switch">
                             <label><input type="checkbox" checked><span class="lever"></span></label>
                         </div>
                     </li>
                     <li>
                         <span>Email Redirect</span>
                         <div class="switch">
                             <label><input type="checkbox"><span class="lever"></span></label>
                         </div>
                     </li>
                 </ul>
                 <p>SYSTEM SETTINGS</p>
                 <ul class="setting-list">
                     <li>
                         <span>Notifications</span>
                         <div class="switch">
                             <label><input type="checkbox" checked><span class="lever"></span></label>
                         </div>
                     </li>
                     <li>
                         <span>Auto Updates</span>
                         <div class="switch">
                             <label><input type="checkbox" checked><span class="lever"></span></label>
                         </div>
                     </li>
                 </ul>
                 <p>ACCOUNT SETTINGS</p>
                 <ul class="setting-list">
                     <li>
                         <span>Offline</span>
                         <div class="switch">
                             <label><input type="checkbox"><span class="lever"></span></label>
                         </div>
                     </li>
                     <li>
                         <span>Location Permission</span>
                         <div class="switch">
                             <label><input type="checkbox" checked><span class="lever"></span></label>
                         </div>
                     </li>
                 </ul>
             </div>
         </div>
     </div>
 </aside>
 <!-- #END# Right Sidebar -->
 </section>

 <section class="content">
 <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>">
         <?php if ($this->session->flashdata('pesan')) { ?>

         <?php } ?>
     <!-- <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div> -->

     <!-- Widgets -->
     <!-- <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">playlist_add_check</i>
                        </div>
                        <div class="content">
                            <div class="text">NEW TASKS</div>
                            <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">help</i>
                        </div>
                        <div class="content">
                            <div class="text">NEW TICKETS</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">forum</i>
                        </div>
                        <div class="content">
                            <div class="text">NEW COMMENTS</div>
                            <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">NEW VISITORS</div>
                            <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </div> -->
     <!-- #END# Widgets -->
     <!-- CPU Usage -->
     <div class="row clearfix">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
             <div class="card">
                 <div class="header">
                     <div class="row clearfix">
                         <div class="col-xs-12 col-sm-6">

                             <h4>SELAMAT DATANG DI SISTEM CUSTOMER CARE SYSTEM</h4>
                         </div>
                         <div class="col-xs-12 col-sm-6 align-right">
                             <div class="switch panel-switch-btn">
                                 <!-- <span class="m-r-10 font-12">REAL TIME</span>
                                        <label>OFF<input type="checkbox" id="realtime" checked><span class="lever switch-col-cyan"></span>ON</label> -->
                             </div>
                         </div>
                     </div>

                     <h5><b>DATA PELAPORAN</b></h5>
                     <br>
                    
                     <ul class="header-dropdown m-r--5">
                         <li class="dropdown">
                             <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                 aria-haspopup="true" aria-expanded="false">
                                 <i class="material-icons">more_vert</i>
                             </a>
                             <ul class="dropdown-menu pull-right">
                                 <li><a href="javascript:void(0);">Action</a></li>
                                 <li><a href="javascript:void(0);">Another action</a></li>
                                 <li><a href="javascript:void(0);">Something else here</a></li>
                             </ul>
                         </li>
                     </ul>
                 </div>
                 <div class="body">
                     <!-- <div id="real_time_chart" class="dashboard-flot-chart"></div> -->
                 </div>
             </div>
         </div>
     </div>
     </div>
     </div>
     </div>
 </section>