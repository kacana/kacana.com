<!-- Create the tabs -->
<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    <li class="active"><a href="#control-sidebar-chat-tab" data-toggle="tab"><i class="fa fa-comments-o"></i> Chat</a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <!-- Home tab content -->
    <div class="tab-pane active" id="control-sidebar-chat-tab">
        <h3 class="control-sidebar-heading">Message Processing</h3>
        <ul class='control-sidebar-menu'>
            <li>
                <a data-thread-id="15" href="#create-thread-message" class="create-thread-message" >
                    <i class="menu-icon fa fa-paper-plane bg-green"></i>
                    <div class="menu-info">
                        <h4 class="control-sidebar-subheading">Chat 221</h4>
                        <p>19/12/2016 <small>20:12</small></p>
                    </div>
                </a>
            </li>
            <li>
                <a >
                    <i class="menu-icon fa fa-paper-plane bg-green"></i>
                    <div class="menu-info">
                        <h4 class="control-sidebar-subheading">Chat 432</h4>
                        <p>25/12/2016 <small>20:12</small></p>
                    </div>
                </a>
            </li>
        </ul><!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Message Thread</h3>
        <ul class='control-sidebar-menu'>
            <li>
                <a >
                    <i class="menu-icon fa fa-check bg-aqua"></i>
                    <div class="menu-info">
                        <h4 class="control-sidebar-subheading">Chat 126</h4>
                        <p>19/12/2016 <small>20:12</small></p>
                    </div>
                </a>
            </li>
            @for($i = 0 ; $i < 5 ;$i++)
                <li>
                    <a >
                        <i class="menu-icon fa fa-check bg-aqua"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Chat 57{{$i}}</h4>
                            <p>25/12/2016 <small>20:12</small></p>
                        </div>
                    </a>
                </li>
            @endfor
        </ul>
    </div>
</div>