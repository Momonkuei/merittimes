//JavaScript Document
//更換驗證碼圖片
function RefreshImage(valImageId) {
    var objImage = document.images[valImageId];
    if (objImage == undefined) {
        return;
    }
    var now = new Date();
    objImage.src = objImage.src.split('?')[0] + '/captcha.php?s=' + new Date().getTime();
}

function RefreshImage2(valImageId) {
    var objImage = document.images[valImageId];
    if (objImage == undefined) {
        return;
    }
    var now = new Date();
    objImage.src = objImage.src.split('?')[0] + '/captcha2.php?s=' + new Date().getTime();
}
