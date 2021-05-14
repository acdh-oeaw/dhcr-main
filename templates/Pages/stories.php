<?php $this->set('bodyClasses', 'stories'); ?>
<?php $this->start('page_head'); ?>
    <div class="intent">
        <p class="linklist-title-desc">Collection of inks featured in our instagram-posts</p>
    </div>
<?php $this->end(); ?>

<div class="linklist-content-div">
    <ul></ul>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $.ajax({
            url : "https://shared.acdh.oeaw.ac.at/dhcr/mylist.txt",
            dataType: "text",
            success : function (data) {
                $("body ul").append(data);
            }
        });
    });
</script>



