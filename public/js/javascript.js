/**********************************************
 * 投稿時に画像をアップロードした時、画像ファイルであれば
 * プレビュー画面を表示する
 **********************************************/
$(document).on('change', ':file', function() {

    var files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) {
        //選択ダイアログでキャンセルを押下したら画像を非表示にする
        $('.imagePreviewPre').css('display', 'none');
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
            $('.imagePreviewPre').css('display', '');

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

/********************************************
 * 投稿を削除する時、確認ダイアログを表示する
 ********************************************/
$(function (){
    $(".btn-delete").click(function(){

        if(confirm("削除します。よろしいですか？")){
            // そのままsubmit処理を実行（※削除）
        }else{
            // キャンセル
            return false;
        }
    });
});
