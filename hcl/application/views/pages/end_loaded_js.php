<script>
    $(function () {
        $hcl.finishProgress();
        if (firstLoad){
            firstLoad = false;
        }

        var myPage = "<?php echo $page; ?>";
        //var robot = "<?php //echo $robot; ?>//";
        $('.selected').removeClass('selected');
        $('.menu_container').find('a[href="#'+ myPage +'"]').addClass('selected');
        $('.mobile_menu').find('a[href="#'+ myPage +'"]').addClass('selected');
        if (myPage=="main" && current_page!="main" && current_page!=myPage && robot==''){
            $hcl.load(current_page);
        }
    });
</script>