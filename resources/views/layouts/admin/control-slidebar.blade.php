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

<script id="template-chat-list-thread" type="template">
    <li>
        <a data-thread-id="${id}" href="/chat#${id}" class="create-thread-message new-thread">
            <i class="menu-icon fa fa-paper-plane bg-green"></i>
            <div class="menu-info">
                <h4 class="control-sidebar-subheading">Chat ${id}</h4>
                <p>${day}<small> ${time}</small></p>
            </div>
        </a>
    </li>
</script>

<script id="template-chat-list-old-thread" type="template">
    <li>
        <a data-thread-id="${id}" href="/chat#${id}" class="create-thread-message">
            <i class="menu-icon fa fa-check bg-aqua"></i>
            <div class="menu-info">
                <h4 class="control-sidebar-subheading">Chat ${id}</h4>
                <p>${day}<small> ${time}</small></p>
            </div>
        </a>
    </li>
</script>