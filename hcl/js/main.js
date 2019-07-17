$hcl.checkUri();
if (current_page.length == ''){
    current_page = 'main';
}
if ($('.menu_container').find('a[href="#'+current_page+'"]').length==0) {
    current_page = "main";
}
progressBar = $('#progressBar');
$hcl.setProgress(0);

$('.menu_container').find('a').click(function () {
    $('.menu_container').find('.selected').removeClass('selected');
    $(this).addClass('selected');
    var page = $(this).attr('href').slice(1);
    if (current_page!=page){
        $hcl.load(page);
    }
});

$('.mobile_menu').find('a').click(function () {
    $('.mobile_menu').find('.selected').removeClass('selected');
    $(this).addClass('selected');
    var page = $(this).attr('href').slice(1);
    if (current_page!=page) {
        $hcl.load(page);
    }
});

current_page = "main";
$hcl.load('fileManager');


var Wwdth = $(window).width();
var Whght = $(window).height();
var WhghtI = window.innerHeight;
var blockMaxHeight;
var blockMinHeight;
var ifStartWhy = false;
var whyInt;
var mm;
var targ2;
var isMobile = false;
var formActionSpan = "";

if (Wwdth<=mobile_width){
    isMobile = true;
}

function revertWhy() {
    if (!$('.flipper').hasClass('escape')){
        $('.flipper').addClass('escape');
    } else {
        $('.flipper').removeClass('escape');
    }
}

function setMobileBlockHeight(obj,persent) {
    blockMaxHeight = WhghtI*persent/100;
    blockMinHeight = WhghtI*(persent-2)/100;
    $(obj).css('max-height',blockMaxHeight);
    $(obj).css('min-height',blockMinHeight);
}

function getScriptForCurrentPage() {

}


$hcl.getFolder = function getFolder() {
    $.ajax({
        type: "POST",
        url: "/actions/get_folder",
        data: {
            source: ""
        },
        // beforeSend: function(){
        //     $hcl.startProgress();
        // },
        success: function(data){
            // alert(data);
            // console.log(data);
            var resp = $hcl.init_resp(data);
            if (!resp.files){
                return;
            }

            var files = JSON.parse(resp.files);

            for(var i = 0; i <= files.length; i++){
                console.log(files[i]);
            }

            // $hcl.downloadFile(files[0]);
        }
    });
}

$hcl.getFolder();


$hcl.downloadFile = function downloadFile($path='') {
    window.location.href = "/actions/download_photo/"+$path;
};

$hcl.media = {
    current: "",
    level: 1,
    back: []
};

$hcl.getDrive = function (hashfile = '') {
    // if (hashfile!=''){
    $hcl.media.current = hashfile;
    // }
    $.ajax({
        type: "POST",
        url: "/actions/getDrive",
        data: {
            current: $hcl.media.current,
            level: $hcl.media.level,
            back: $hcl.media.back
        },
        success: function(data){
            console.log(data);
            var resp = JSON.parse(data);
            // console.log(resp);

            if (resp.action == "download"){
                $hcl.downloadFile(resp.hashed);
                return;
            } else {
                $hcl.media.back.push($hcl.media.current);
            }

            var files = '';
            var media = '';
            var bread = [];
            var level = 1;
            try{
                level = resp[0].level;
                bread = JSON.parse(resp[0].bread);
                files = JSON.parse(resp[0].files);
                media = JSON.parse(resp[0].media);
            } catch (e) {
                console.log('EEE');
            }

            if (bread){
                console.log(bread);
                var breadMenu = $('#breadmenu');
                breadMenu.remove('.leveled');
                // bread.forEach(function (item, key) {
                //     var el = JSON.parse(item);
                //     breadMenu.append('<li class="breadcrumb-item leveled"><a href="#" data-hash="'+el[1]+'">'+el[0]+'</a></li>');
                // });
            }

            if (back){
                $('#back').off('click');
                $('#back').click(function () {
                    // alert($hcl.media.back[$hcl.media.back.length-2]);
                    $hcl.getDrive($hcl.media.back[$hcl.media.back.length-2]);
                });
            }

            $('#home').off('click');
            $('#home').click(function () {
                // alert($hcl.media.back[$hcl.media.back.length-2]);
                $hcl.getDrive();
            });

            if (files){
                $html = '';
                files.forEach(function (item, key){
                    console.log(item);
                    $html += "                       <div class=\"one-file col-lg-2 m-1 mb-4 p-0 btn btn-outline-dark border-0\" data-hash='"+item.hashcode+"'>\n" +
                        "                                <div class=\"row text-center m-0\">\n" +
                        "                                    <div class=\"col py-2\">\n" +
                        "                                        <i class=\"fas fa-5x fa-"+ item.filetype +"\"></i>\n" +
                        "                                    </div>\n" +
                        "                                    <div class=\"col\">\n" +
                        "                                        <span class=\"mt-2 small\">"+item.name+"</span>\n" +
                        "                                    </div>\n" +
                        "                                </div>\n" +
                        "                            </div>"
                });
                $('#activeDir').html($html);

                $('.one-file').off('click');
                $('#activeDir').find('.one-file').click(function () {
                    // alert($(this).attr('data-hash'));
                    var hash = $(this).attr('data-hash');
                    // $hcl.media.current = $(this).attr('data-hash');
                    $hcl.getDrive(hash);
                });
            }
        }
    });
};


$hcl.getDrive();