<!-- Create the tabs -->
<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    <li class="active"><a href="#control-sidebar-chat-tab" data-toggle="tab"><i class="fa fa-comments-o"></i> Chat</a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <!-- Home tab content -->
    <div class="tab-pane active" id="control-sidebar-chat-tab">
        <h3 class="control-sidebar-heading">Message Processing</h3>
        <ul id="list-chat-right-side-new" class='control-sidebar-menu'>

        </ul><!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Message Thread</h3>
        <ul id="list-chat-right-side-old" class='control-sidebar-menu'>

        </ul>

        <div class="hidden">
            <audio id="chat-sound-new-message" controls>
                <source src="/sound/message.mp3" type="audio/mpeg">
            </audio>
        </div>

        <div class="hidden">
            <audio id="chat-sound-new-thread" controls>
                <source src="/sound/thread.mp3" type="audio/mpeg">
            </audio>
        </div>
    </div>
</div>