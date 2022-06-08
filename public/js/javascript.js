/**********************************************
 * 投稿時に画像をアップロードした時、画像ファイルであれば
 * プレビュー画面を表示する
 **********************************************/
$(document).on('change', ':file', function() {
    var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.parent().parent().next(':text').val(label);

    var files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) {
        return;
    }
    if (/^image/.test( files[0].type)){ // only image file
        var reader = new FileReader(); // instance of the FileReader
        reader.readAsDataURL(files[0]); // read the local file
        reader.onloadend = function(){ // set image data as background of div
            input.parent().parent().parent().parent().prev().children().next().children('.imagePreview').css("background-image", "url("+this.result+")");
        }
        $('.imagePreviewPre').addClass('imagePreview');

        //編集画面で既存画像があれば非表示にする
        $('.imagePreviewEdit').css('display', 'none');
    } else {
        window.alert('画像ファイルではありません');
    }
});

/********************************************
 * ナビゲーションバーのログインユーザアイコンに
 * マウスオーバーしたらユーザ名やメールアドレスを
 * 表示する
 ********************************************/
$(function(){
    $('.user-info').hide();
    $('.icon').hover(
        function(){
            $(this).children('.user-info').fadeIn('fast');
          },
          function(){
            $(this).children('.user-info').fadeOut('slow');
          }
    );
});

$(function (){
    $(".btn-delete").click(function(){

        if(confirm("本当に削除しますか？")){
            // そのままsubmit処理を実行（※削除）
        }else{
            // キャンセル
            return false;
        }
    });
});
