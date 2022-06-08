/**********************************************
 * 投稿時に画像をアップロードした時、画像ファイルであれば
 * プレビュー画面を表示する
 **********************************************/
$(document).on('change', ':file', function() {

    var files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) {
        return;
    }
    if (/^image/.test( files[0].type)){
        var reader = new FileReader();
        reader.readAsDataURL(files[0]);
        
        reader.onloadend = function(){
            //前回選択した画像を削除する
            $('.img-create').remove();

            //画像プレビュー用クラスを追加する
            $('.imagePreviewPre').addClass('imagePreview');

            //選択した画像をimg要素として追加する
            var add = '<img class="img-create" src="'+this.result+'">';
            $('.imagePreview').append(add);

            //編集画面で既存画像があれば非表示にする
            $('.imagePreviewEdit').css('display', 'none');
        }
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
